'''
Converts all Sass files to regular css. The Sass preprocessor drops the '@charset "UTF-8"'
declaration at the top of our css files; this script adds it back in.
'''

from os import listdir
from subprocess import call
try:
  for f in listdir('.'):
    if f[-5:] == '.scss':
      call('sass --style expanded %s ../%s.css' % (f, f[:-5]), shell=True)
  for f in listdir('..'):
    if f[-4:] == '.css':
      current_file = f
      try: 
        lines = []
        buf = None
        changed = False
        with open('../%s' % f, 'r') as cssfile:
          lines = cssfile.readlines()
          line = lines[0]
          try:
            line.index('@charset "UTF-8"')
          except ValueError:
            changed = True
            line = '@charset "UTF-8";\n\n' + line
            lines[0] = line
            buf = ''.join(lines)
        if changed:
          with open('../%s' % f, 'w') as cssfile:
            cssfile.write(buf)
      except Exception as e:
        with open('python_error_log.txt', 'a') as f:
          from datetime import datetime
          now = datetime.now()
          timestamp = now.strftime('%Y-%m-%d %H:%M')
          this_file = 'convert_scss_to_css.py'
          f.write('%s\t%s\t%s\t%s\n' % (timestamp, this_file, current_file, e))
except Exception as e:
  with open('python_error_log.txt', 'a') as f:
    from datetime import datetime
    now = datetime.now()
    timestamp = now.strftime('%Y-%m-%d %H:%M')
    this_file = 'convert_scss_to_css.py'
    f.write('%s\t%s\t%s\n' % (timestamp, this_file, e))
