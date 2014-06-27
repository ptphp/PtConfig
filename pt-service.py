#!/usr/bin/python
import time
import os
pid = os.getpid()

while 1:    
    f = open("/tmp/pt_service.log","a+")
    f.write(str(pid)+" | "+str(time.time())+"\n")
    f.close()
    time.sleep(1)
