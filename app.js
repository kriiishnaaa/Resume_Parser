express = require('express');
const multer = require('multer');
const path = require('path');
const { spawn } = require('child_process');
const fs = require('fs');

const app = express();
app.use(express.static(path.join(__dirname, 'public')));

// Set storage for uploaded files
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, 'uploads/'); // Store files in the 'uploads' directory
  },
  filename: (req, file, cb) => {
    const uniquePrefix = Date.now() + '-'; // Add a unique prefix using the current timestamp
    const originalname = file.originalname;
    const extension = path.extname(originalname);
    const filename = 'resume_' + uniquePrefix + extension;
    cb(null, filename); // Use the custom filename
  },
});

// Create multer upload middleware
const upload = multer({ storage: storage });

// Serve the HTML file for the front view
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

// Handle file upload
app.post('/upload', upload.single('file'), (req, res) => {
  if (!req.file) {
    // No file uploaded
    res.status(400).send('No file was uploaded.');
  } else {
    console.log('File uploaded:', req.file.path);

    // Call your Python script for processing
    const pythonProcess = spawn('python', ['Text_extraction.py', req.file.path]);

    let parsedData = '';

    // Collect the parsed data from Python script
    pythonProcess.stdout.on('data', (data) => {
      parsedData += data.toString();
    });

    pythonProcess.stderr.on('data', (data) => {
      console.error(`Python script error: ${data}`);
      // Handle any errors that occur during parsing
      res.status(500).send('An error occurred during parsing.');
    });

    // When the Python script finishes executing
    pythonProcess.on('close', (code) => {
      if (code === 0) {
        // Write the parsed data to a JSON file
        const jsonFilePath = path.join(__dirname, 'parsedData.json');
        fs.writeFile(jsonFilePath, parsedData, (err) => {
          if (err) {
            console.error('Error writing JSON file:', err);
            res.status(500).send('An error occurred while saving the parsed data.');
          } else {
            // Redirect to the '/display' route
            res.redirect('/display');
          }
        });
      } else {
        console.error(`Python script exited with code ${code}`);
        res.status(500).send('An error occurred during parsing.');
      }
    });
  }
});

// Serve the details.html file for displaying the result webpage
app.get('/display', (req, res) => {
  const jsonFilePath = path.join(__dirname, 'data.json');

  fs.readFile(jsonFilePath, 'utf8', (err, data) => {
    if (err) {
      console.error('Error reading JSON file:', err);
      res.status(500).send('An error occurred while reading the parsed data.');
    } else {
      const parsedData = JSON.parse(data);
      const templateFilePath = path.join(__dirname, 'details.html');
      fs.readFile(templateFilePath, 'utf8', (err, template) => {
        if (err) {
          console.error('Error reading HTML template file:', err);
          res.status(500).send('An error occurred while reading the template file.');
        } else {
          const filledTemplate = fillTemplateWithData(template, parsedData);
          res.send(filledTemplate);
        }
      });
    }
  });
});

// Helper function to fill the HTML template with data
function fillTemplateWithData(template, data) {
  let filledTemplate = template;
  for (const key in data) {
    const value = data[key];
    const placeholder = `{{${key}}}`;
    filledTemplate = filledTemplate.replace(new RegExp(placeholder, 'g'), value);
  }
  return filledTemplate;
}

// Start the server
app.listen(3000, () => {
  console.log('Server started on port 3000');
});
