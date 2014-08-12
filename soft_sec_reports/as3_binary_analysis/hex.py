#####################################
#####################################
#	0x53	0x88	0xc0	0xde
#	A  		B  		C  		D
#
#	B*C+A  		=>	2f
#	A^D^(B+C)	=>	5b
#
#	(B*C+A) & 0xff 		== 0x2f
#	A^D^(B+C) & 0xff	== 0x5b
#####################################
def getArgs(h):
	A=(int(h)&int('0xff00',16)>>8)&int('0x00ff',16)
	B=int(h)&int('0x00ff',16)
	#print hex(A)+":A B:"+hex(B)
	print hex(h),hex(A), hex(B)
	return A,B

def calc1(A,B,C,D):
	res=(B*C+A)&int('0xff',16)
	return res==int('0x2f',16)

def calc2(A,B,C,D):
	res=(A^D^(B+C))&int('0xff',16)
	return res==int('0x5b',16)

def c4():
	A=0
	B=0
	C=int('0xc0',16)
	D=int('0xde',16)

	ar = range(0,int('0xffff',16)+1)
	res =[]
	#for i in ar:
	for i in range(0,256):
		for j in range(0,256):
			A=i
			B=j
			#hex1= int(str(hex(i)),16)
			#A,B=getArgs(hex1)
			if (calc1(A,B,C,D) and calc2(A,B,C,D)):
				print "Time found!!"
				print "A="+hex(A)
				print "B="+hex(B)
				print "set $rsi="+hex(A)[2]+hex(A)[3]+hex(B)[2]+hex(B)[3]+"c0de"

def main():
	c4()

main()