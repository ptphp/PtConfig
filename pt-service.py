#!/usr/bin/python
import time
import os
pid = os.getpid()

while 1:    
    f = open("/tmp/pt_service.log","a+")
    msg = str(pid)+" | "+str(time.time())+" | " + __file__
    print msg
    f.write(msg +"\n")
    f.close()
    time.sleep(1)
