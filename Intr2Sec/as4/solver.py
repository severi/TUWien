import sys


def isASCII(num):
    return (num>=ord('a') and num<=ord('z')) or (num>=ord('A') and num<=ord('Z'))



def getInputs(msg='src/msg.txt',inputs='src/input.txt'):#'msg.txt','inputs.txt'
    mes = open(msg,'r').read()
    inp = open(inputs,'r')
    inputV = []
    for i in inp:
        inputV.append(i.strip().rstrip())
    return mes.strip().rstrip(),inputV

def xorNum(num1,num2):
    decM = int(str(num1),16)
    decI = int(str(num2),16)
    return decM^decI


def xorMsg(msg,inp):
    n=2
    inpV = [inp[i:i+n] for i in range(0, len(inp), n)]
    msgV = [msg[i:i+n] for i in range(0, len(msg), n)]

    length = min(len(inpV),len(msgV))
    result=[]
    for i in range(length):
        result.append(xorNum(inpV[i],msgV[i]))
    return result

'''
find the places in the xorred string where in one or both of the
strings locates a SPACE
'''
def checkSpace(inpVec):
    found={}
    for i in range(len(inpVec)):
        if inpVec[i]==0:
            found[i]="!"
        elif isASCII(inpVec[i]):
            found[i]=unichr(inpVec[i])
    return found


'''
check if number num is in all vectors/dictionaries
'''
def numCommon(num, vectors):
    for vec in vectors:
        if num not in vec:
            return False
    return True

def main():
# xor the message with all the inputs
    message, inp = getInputs()
    xor = []
    for i in inp:
        xor.append(xorMsg(message,i))

# get locations in the xorred strings where
# SPACE is used in one or both of the strings
    text=[]
    for m in xor:
        text.append(checkSpace(m))

# find the idx:s where in all strings is a space used
# --> the message to be decrypted contains a space in
# that particular location
    spaceIdx=[];
    for t in text:
        for num in t:
            if numCommon(num,text):
                spaceIdx.append(num)
    for t in text:
        st=""
        for i in range(len(xor[0])):
            if i in spaceIdx:
                st+="/";
            elif i in t:
                st+=str(t[i])
            else:
                st+="_";
        print st

if __name__ == '__main__':
    main()
