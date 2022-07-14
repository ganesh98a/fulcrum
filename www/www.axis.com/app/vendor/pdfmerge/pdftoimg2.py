import shutil
import os
import tempfile
import pdf2image
import sys

#filename = 'test'

filename = sys.argv[3]

pdf_path = sys.argv[1]+sys.argv[2]
temp_path = sys.argv[1]
output_path =sys.argv[1]

#images = pdf2image.convert_from_path('pdf path', output_folder='output path', fmt='format')
# To convert the PDF to Image
images = pdf2image.convert_from_path(pdf_path,dpi=200,output_folder=temp_path,fmt='jpg',grayscale=False,transparent=False)

#base_filename  =  os.path.splitext(os.path.basename(images[0].filename))[0] + '.jpg'  
fileArray = []
for f in images:
 src = f.filename
 fileArray.append(src)
 src_file  =  os.path.splitext(os.path.basename(src))[0] + '.jpg'
 temp_name = src_file.split('-', 5)
 img_name = temp_name[5]
 dst_file = filename + '_'+ img_name
 dst = output_path + '/' + dst_file
 shutil.copy(src,dst)
f.close()
for f1 in fileArray:
 print(f1)
 os.remove(f1)






