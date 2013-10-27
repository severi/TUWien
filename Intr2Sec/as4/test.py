import unittest
from solver import *

class oneTimePad(unittest.TestCase):
    def testOpenFile(self):
        msg,inp = getInputs("test/testmsg.txt","test/testInp.txt")
        self.assertEqual('2a1c012a1c01',str(msg))
        self.assertEqual(len(inp),2)

    def testXor(self):
        self.assertEqual(xorNum('2a','2a'),0)
        self.assertEqual(xorNum('2a','23'),9)
        self.assertEqual(xorNum('BB','01'),186)

    def testXorMsg(self):
        vector=[0,169,33,11]
        self.assertEqual(xorMsg("0ba22a00","0b0b0b0b0b0b"),vector);

    def testASCII(self):
        self.assertTrue(isASCII(ord('a')))
        self.assertTrue(isASCII(ord('z')))
        self.assertTrue(isASCII(ord('A')))
        self.assertTrue(isASCII(ord('Z')))
        self.assertTrue(isASCII(ord('C')))
        self.assertTrue(isASCII(ord('c')))
        self.assertFalse(isASCII(20))
        self.assertFalse(isASCII(ord(' ')))
    def testCheckSpaces(self):
        self.assertEqual(checkSpace([0,ord('a'),3,5,ord('B')]),{0:" ",1:'a',4:'B'})





if __name__ == '__main__':
    unittest.main()




