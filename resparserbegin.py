from pyresparser import ResumeParser
import nltk
import spacy
nltk.download('stopwords')
spacy.load('en_core_web_sm')
resume_path = 'sampleresume.pdf'
parser = ResumeParser(resume_path)
data = parser.get_extracted_data()
name = data['name']
email = data['email']
phone = data['mobile_number']
skills = data['skills']
experience = data['experience']
print(f"Name: {name}")
print(f"Email: {email}")
print(f"Phone: {phone}")
print(f"Skills: {skills}")
print(f"Experience: {experience}")
