package encodingsms;

import java.util.ArrayList;
import java.util.BitSet;
import java.util.List;

/**
 * @author severi
 */

public class Encoder {
    
    private UnicodeToSMS su;
    
    public Encoder(){
        su = new UnicodeToSMS();
    }
  
    public byte[] encode(String msg){
        // msg= SMS Rulz 
        byte[] arrayByte = hexToBytes(su.strToSMS(msg));
        
        // arrayByte= 53 4D 53 20 52 75 6C 7A
        int bitLen = arrayByte.length;
        
        // bits = 10100110 10011010 10100110 0100000 01010010 01110101 01101100 01111010
        List<BitSet> bits = new ArrayList();
        for (byte b: arrayByte)
            bits.add(byteToBit(b));
        
        int amount=1; //amount of bits needed to transfer to fill a byte (1-7)
        int msb=8;
        for (int i=0; i<bits.size()-1; ++i){
            if (i!=0 && i%7==0) // remove bitSet that is empty after bit transfer
                bits.remove(i);
            
            // 11 0(011011) -> (011011)11 0
            for (int j=amount; j>=1; --j)
                bits.get(i).set(msb-((amount+1)-j), bits.get(i+1).get(j-1));
            
            // shift the bits left in the next bitset after the lsb bits have
            // been transfered
            // _ 0 1 0 1 0 0 1 -> _ 0 1 0_ _ _ _ -> _ _ _ _ _ 0 1 0
            BitSet next = bits.get(i+1);
            bits.set(i+1, next.get(amount, Math.max(amount, next.length())));
            
            amount= amount==7 ? 1:amount+1;
            
        }
        
        // convert the encoded bitset array to byte array
        double byteL = 8;
        double septetL = 7;
        double arrayBL = arrayByte.length;
        byte[] encodedBytes = new byte[(int) Math.ceil(arrayBL*septetL/byteL)];
        
        for (int i=0;i<encodedBytes.length;++i)
            encodedBytes[i]=bitToByte(bits.get(i));
       
        return encodedBytes;
    }
    
    /*
     *  Function for converting a bitset to byte 
     */
    public byte bitToByte(BitSet b){
        byte tmp=0;
        for (int i=0;i<b.length();++i)
            if (b.get(i))
                tmp|=1<<i;
        return tmp;
    }
   
     /*
      *  Function for converting a bytes to hex string 
      */
    final protected static char[] hexArray = "0123456789ABCDEF".toCharArray();
    public static String bytesToHex(byte[] bytes) {
        char[] hexChars = new char[bytes.length * 2];
        for ( int j = 0; j < bytes.length; j++ ) {
            int v = bytes[j] & 0xFF;
            hexChars[j * 2] = hexArray[v >>> 4];
            hexChars[j * 2 + 1] = hexArray[v & 0x0F];
        }
        return new String(hexChars);
    }
    
     /*
      *  Function for converting a byte to hex string 
      */
    public static String byteToHex(byte b) {
        char[] hexChars = new char[2];
        int v = b & 0xFF;
        hexChars[0] = hexArray[v >>> 4];
        hexChars[1] = hexArray[v & 0x0F];
        return new String(hexChars);
    }
    
     /*
      *  Function for converting a hex string to byte 
      */
    public static byte hexToByte(String s){
        return (byte)Integer.parseInt(s, 16);
    }
    
     /*
      *  Function for converting a hex string to bytes 
      */
    public static byte[] hexToBytes(String s){
        byte[] ar = new byte[s.length()/2];
        for (int i=0; i<s.length()/2;i++)
            ar[i]=hexToByte(s.substring(i*2, i*2+2));
        return ar;
    }
    
     /*
      *  Function for converting a byte to bitset
      */
    public static BitSet byteToBit(byte b){
        BitSet bit = new BitSet();
        for (int i=0; i<8; ++i)
            if ( ((b>>i)&1) == 1 )
                bit.set(i);
        return bit;
    }

}


