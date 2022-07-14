''' Convert .css to Sass, replace two spaces with \t '''

import re

current_file = None
try:
  from os import listdir
  from subprocess import call
  for f in listdir('..'):
    current_file = f
    if f[-4:] == '.css':
      call('sass-convert --to scss ../%s %s.scss' % (f, f[:-4]), shell=True)
  for f in listdir('.'):
    current_file = f
    if f[-5:] == '.scss':
      lines = []
      with open(f, 'r') as scssfile:
        lines = scssfile.readlines()
      for i in range(len(lines)):
        line = lines[i]
        line = re.sub('  ', '\t', line)
        lines[i] = line
      buf = ''.join(lines)
      with open(f, 'w') as scssfile:
        scssfile.write(buf)
except Exception as e:
  with open('python_error_log.txt', 'a') as f:
    from datetime import datetime
    now = datetime.now()
    timestamp = now.strftime('%Y-%m-%d %H:%M')
    this_file = 'convert_css_to_scss.py'
    f.write('%s\t%s\t%s\t%s\n' % (timestamp, this_file, current_file, e))
