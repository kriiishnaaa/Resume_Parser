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
print(list)
