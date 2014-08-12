/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import encodingsms.Encoder;
import encodingsms.UnicodeToSMS;
import java.io.UnsupportedEncodingException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

/**
 *
 * @author severi
 */
public class EncodeTest {
    
    public EncodeTest() {}
    @BeforeClass
    public static void setUpClass() {}
    @AfterClass
    public static void tearDownClass() {}
    @Before
    public void setUp() {}
    @After
    public void tearDown() {}
    
    @Test
    public void encode8to7(){
        Encoder e = new Encoder();
        String str = new String("SMS Rulz");
        assert(new String(
                e.encode(str)).equals(
                        new String(TEnc.unencodedSeptetsToEncodedSeptets(
                                str.getBytes()))));
    }
    
    @Test
    public void encodeLonger(){
        Encoder e = new Encoder();
        String str = new String("SMS RulzSMS R");
        assert(Encoder.bytesToHex(e.encode(str)).equals(
                        Encoder.bytesToHex(TEnc.unencodedSeptetsToEncodedSeptets(
                                str.getBytes()))));
    }
    
    
    @Test
    public void encodeShorter(){
        Encoder e = new Encoder();
        String str = new String("SM ");
        assert(Encoder.bytesToHex(e.encode(str)).equals(
                        Encoder.bytesToHex(TEnc.unencodedSeptetsToEncodedSeptets(
                                str.getBytes()))));
    }
    
    @Test
    public void encodeEmpty(){
        Encoder e = new Encoder();
        String str = new String("");        
        assert(Encoder.bytesToHex(e.encode(str)).equals(
                        Encoder.bytesToHex(TEnc.unencodedSeptetsToEncodedSeptets(
                                str.getBytes()))));
    }
    
    @Test
    public void encodeSpecial(){
        /*
                S       M       S                   R       u         €
                53      4D      53         20       52      75      1B65
            01010011 01001101 01010011 00100000 01010010 01110101 00011011 01100101  7bit
             1010011  1001101  1010011  0100000  1010010  1110101  0011011  1100101  1
            11010011   100110  1010011  0100000  1010010  1110101  0011011  1100101  2
            11010011 11100110 00010100     0100  1010010  1110101  0011011  1100101  3
            11010011 11100110 00010100 00100100      101  1110101  0011011  1100101  4
            11010011 11100110 00010100 00100100 10101101       11  0011011  1100101  5
            11010011 11100110 00010100 00100100 10101101 01101111        0  1100101  6
            11010011 11100110 00010100 00100100 10101101 01101111 11001010           7

            D3E61424AD6FCA                                                     7bit->8     
        */
        
        Encoder e = new Encoder();
        String str = new String("SMS Ru\u20AC"); // SMS Ru€
        assert(Encoder.bytesToHex(e.encode(str)).equals("D3E61424AD6FCA"));
    }
    
}
