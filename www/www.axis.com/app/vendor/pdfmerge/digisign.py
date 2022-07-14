#!/usr/bin/env vpython3
# *-* coding: utf-8 *-*
import sys
import datetime
from cryptography.hazmat import backends
from cryptography.hazmat.primitives.serialization import pkcs12
from endesive import pdf

#import logging
#logging.basicConfig(level=logging.DEBUG)

fname = sys.argv[1]
filepath = sys.argv[2]
filename = sys.argv[3]
secretkeypath = sys.argv[4]
print(secretkeypath )

def main():
    date = datetime.datetime.utcnow() - datetime.timedelta(hours=12)
    date = date.strftime('%Y%m%d%H%M%S+00\'00\'')
    dct = {
        b'sigflags': 3,
        # b'sigpage': 0,
        b'sigbutton': True,
        #b'signature_img': b'signature_test.png',
        b'contact': b'suganthi@yopmail.com',
        b'location': b'san francisco',
        b'signingdate': date.encode(),
        b'reason': b'vendor signature',
        b'signature': b'suganthidevi',
 	   b'signaturebox': (80, 0, 10, 80),
        b'signaturebox': (500, 50, 0, 80),
    }
    print(dct)
    with open(secretkeypath+'app/vendor/pdfmerge/demo2_user1.p12', 'rb') as fp:
        p12 = pkcs12.load_key_and_certificates(fp.read(), b'1234', backends.default_backend())
    fname = 'Blank.pdf'
    if len (sys.argv) > 1:
        fname = sys.argv[1]
    datau = open(fname, 'rb').read()
    datas = pdf.cms.sign(datau, dct,
        p12[0],
        p12[1],
        p12[2],
        'sha256'
    )
    #fname = fname.replace('.pdf', filename +'-signed.pdf')
    with open(fname, 'wb') as fp:
        fp.write(datau)
        fp.write(datas)


main()
