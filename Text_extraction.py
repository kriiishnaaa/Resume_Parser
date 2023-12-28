import os
from PIL import Image
import pytesseract
import docx
import PyPDF2
import re
import json
# import textract
# import tempfile
# import subprocess
pytesseract.pytesseract.tesseract_cmd=r"C:\Program Files\Tesseract-OCR\tesseract.exe"
def extract_form_image(im_path):
    im=Image.open(im_path)
    text=pytesseract.image_to_string(im)
    return text
def extract_from_doc(doc_path):
    doc=docx.Document(doc_path)
    extracted_text=""
    for paragraph in doc.paragraphs:
        for run in paragraph.runs:
            extracted_text+=run.text
    return extracted_text
def extract_from_pdf(pdf_path):
    with open(pdf_path,'rb') as file:
        pdf=PyPDF2.PdfReader(file)
        text=""
        for pagenum in range(len(pdf.pages)):
            page=pdf.pages[pagenum]
            text+=page.extract_text()+"\n"
    return text
def extract_text_from_resume(path):
    _, extension=os.path.splitext(path)
    if extension=='.docx':
        return extract_from_doc(path)
    elif extension=='.pdf':
        return extract_from_pdf(path)
    elif extension in ['.jpg','.jpeg','.png','.jfif','.pjpeg']:
        return extract_form_image(path)
    else:
        print("Unsupported file format. Please enter the file in either pdf or image or docx format")
def count_frequency(string,keywords):
    frequency={}
    final_freq={}
    words=string.split()
    for word in words:
        if word in frequency:
            frequency[word]+=1
        else:
            frequency[word]=1
    for keys in keywords:
        if keys in frequency:
            final_freq[keys]=frequency[keys]
        else:
            final_freq[keys]=0
    # for keys in keywords:
    #     if keys not in final_freq:
    #         final_freq[keys]=0
    return final_freq
def get_uploaded_file_path():
    folder_path = r'C:\xampp\htdocs\OCR\uploads' 
    files = os.listdir(folder_path)
    files.sort(key=lambda x: os.path.getctime(os.path.join(folder_path, x)))
    if files:
        latest_file = files[-1]
        latest_file_path = os.path.join(folder_path, latest_file)
        return latest_file_path
    else:
        return "No files found in the folder."
resume_path=get_uploaded_file_path()
# filename()
text=extract_text_from_resume(resume_path)
text=text.lower()
# print(text)
keywords=["knowledge","analytical","web","developer","javascript"]
# print(count_frequency(text,keywords))
list=text.split()
# print(list)
def phone_number(lst):
        phone=[]
        ans=""
        pattern=r"\b(\d{3}-\d{3}-\d{4}|\(\d{3}\) \d{3}-\d{4}|\d{10}|\+\d{3}\s\d{4}\s\d{4} | \+\d{12})\b"
        for item in lst:
            matches=re.findall(pattern,item)
            phone.extend(matches)
        for i in phone:
            ans=ans+" "+i
        return ans
def find_email(lst):
    email=[]
    ans=""
    pattern=r"\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b"
    for item in lst:
        matches=re.findall(pattern,item)
        email.extend(matches)
    for i in email:
        ans=ans+" "+i
    return ans
def find_address(lst):
    address=[]
    ans=""
    pattern=r"\d+\s+[\w\s]+\b,\s*\w+\b,\s*\w+\b"
    for item in lst:
        matches=re.findall(pattern,item)
        address.extend(matches)
    for i in address:
        ans=ans+" "+i
    return ans
def education_details(text):
    education_section = []
    ans=""
    education_keywords = ["education","qualification", "academic", "degree", "university", "college","cgpa", "school","b.","m.","bachelor","masters","ph.d."]
    # Iterate through each line of the resume
    lines =text.splitlines()
    for line in lines:
        # Check if the line contains any education-related keywords
        if any(keyword in line for keyword in education_keywords):
            education_section.append(line)
    for i in education_section:
        ans=ans+" "+i
    return ans
def tech_skills(text):
    tech= []
    ans=''
    tech_keywords = ["java", "languages", "framework","analytic"]
   # Iterate through each line of the resume
    lines =text.splitlines()
    for line in lines:
        # Check if the line contains any education-related keywords
        if any(keyword in line for keyword in tech_keywords):
            tech.append(line)
    for i in tech:
        ans=ans+" "+i
        return ans
        
def experience(text):
    exp=[]
    ans=''
    exp_keys=["years","company"]
    l=text.splitlines()
    for line in l:
        if any (key in line for key in exp_keys):
            exp.append(line)
    for i in exp:
        ans=ans+" "+i
        return ans
# print(education_details(text))
resume_data={"CandName":list[0].capitalize()+" "+list[1].capitalize(),"CandContact":phone_number(list),"CandEmail":find_email(list),"CandAddress":find_address(list),"CandEducation":education_details(text),"CandSkills":tech_skills(text),"CandExperience":experience(text)}
# print(resume_data)
filename = "data.json"
with open(filename,"w") as file:
    json.dump(resume_data, file)







    

    
 