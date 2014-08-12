package encodingsms;

import java.util.HashMap;
import java.util.Map;

/**
 *
 * @author severi
 */

// http://www.unicode.org/Public/MAPPINGS/ETSI/GSM0338.TXT


public class UnicodeToSMS {
    
    
    public Map<String, String> map = new HashMap<String, String>();
    
    public UnicodeToSMS(){
        map.put(Encoder.bytesToHex("\u0040".getBytes()), "00");
        map.put(Encoder.bytesToHex("\u00A3".getBytes()), "01");
        map.put(Encoder.bytesToHex("\u0024".getBytes()), "02");
        map.put(Encoder.bytesToHex("\u00A5".getBytes()), "03");
        map.put(Encoder.bytesToHex("\u00E8".getBytes()), "04");
        map.put(Encoder.bytesToHex("\u00E9".getBytes()), "05");
        map.put(Encoder.bytesToHex("\u00F9".getBytes()), "06");
        map.put(Encoder.bytesToHex("\u00EC".getBytes()), "07");
        map.put(Encoder.bytesToHex("\u00F2".getBytes()), "08");
        map.put(Encoder.bytesToHex("\u00E7".getBytes()), "09");
        map.put(Encoder.bytesToHex("\n".getBytes()), "0A");
        map.put(Encoder.bytesToHex("\u00D8".getBytes()), "0B");
        map.put(Encoder.bytesToHex("\u00F8".getBytes()), "0C");
        map.put(Encoder.bytesToHex("\r".getBytes()), "0D");
        map.put(Encoder.bytesToHex("\u00C5".getBytes()), "0E");
        map.put(Encoder.bytesToHex("\u00E5".getBytes()), "0F");
        map.put(Encoder.bytesToHex("\u0394".getBytes()), "10");
        map.put(Encoder.bytesToHex("\u005F".getBytes()), "11");
        map.put(Encoder.bytesToHex("\u03A6".getBytes()), "12");
        map.put(Encoder.bytesToHex("\u0393".getBytes()), "13");
        map.put(Encoder.bytesToHex("\u039B".getBytes()), "14");
        map.put(Encoder.bytesToHex("\u03A9".getBytes()), "15");
        map.put(Encoder.bytesToHex("\u03A0".getBytes()), "16");
        map.put(Encoder.bytesToHex("\u03A8".getBytes()), "17");
        map.put(Encoder.bytesToHex("\u03A3".getBytes()), "18");
        map.put(Encoder.bytesToHex("\u0398".getBytes()), "19");
        map.put(Encoder.bytesToHex("\u039E".getBytes()), "1A");
        map.put(Encoder.bytesToHex("\u00A0".getBytes()), "1B");
        map.put(Encoder.bytesToHex("\u000C".getBytes()), "1B0A");
        map.put(Encoder.bytesToHex("\u005E".getBytes()), "1B14");
        map.put(Encoder.bytesToHex("\u007B".getBytes()), "1B28");
        map.put(Encoder.bytesToHex("\u007D".getBytes()), "1B29");
        map.put(Encoder.bytesToHex("\\".getBytes()), "1B2F");
        map.put(Encoder.bytesToHex("\u005B".getBytes()), "1B3C");
        map.put(Encoder.bytesToHex("\u007E".getBytes()), "1B3D");
        map.put(Encoder.bytesToHex("\u005D".getBytes()), "1B3E");
        map.put(Encoder.bytesToHex("\u007C".getBytes()), "1B40");
        map.put(Encoder.bytesToHex("\u20AC".getBytes()), "1B65");
        map.put(Encoder.bytesToHex("\u00C6".getBytes()), "1C");
        map.put(Encoder.bytesToHex("\u00E6".getBytes()), "1D");
        map.put(Encoder.bytesToHex("\u00DF".getBytes()), "1E");
        map.put(Encoder.bytesToHex("\u00C9".getBytes()), "1F");
        map.put(Encoder.bytesToHex("\u0020".getBytes()), "20");
        map.put(Encoder.bytesToHex("\u0021".getBytes()), "21");
        map.put(Encoder.bytesToHex("\"".getBytes()), "22");
        map.put(Encoder.bytesToHex("\u0023".getBytes()), "23");
        map.put(Encoder.bytesToHex("\u00A4".getBytes()), "24");
        map.put(Encoder.bytesToHex("\u0025".getBytes()), "25");
        map.put(Encoder.bytesToHex("\u0026".getBytes()), "26");
        map.put(Encoder.bytesToHex("\u0027".getBytes()), "27");
        map.put(Encoder.bytesToHex("\u0028".getBytes()), "28");
        map.put(Encoder.bytesToHex("\u0029".getBytes()), "29");
        map.put(Encoder.bytesToHex("\u002A".getBytes()), "2A");
        map.put(Encoder.bytesToHex("\u002B".getBytes()), "2B");
        map.put(Encoder.bytesToHex("\u002C".getBytes()), "2C");
        map.put(Encoder.bytesToHex("\u002D".getBytes()), "2D");
        map.put(Encoder.bytesToHex("\u002E".getBytes()), "2E");
        map.put(Encoder.bytesToHex("\u002F".getBytes()), "2F");
        map.put(Encoder.bytesToHex("\u0030".getBytes()), "30");
        map.put(Encoder.bytesToHex("\u0031".getBytes()), "31");
        map.put(Encoder.bytesToHex("\u0032".getBytes()), "32");
        map.put(Encoder.bytesToHex("\u0033".getBytes()), "33");
        map.put(Encoder.bytesToHex("\u0034".getBytes()), "34");
        map.put(Encoder.bytesToHex("\u0035".getBytes()), "35");
        map.put(Encoder.bytesToHex("\u0036".getBytes()), "36");
        map.put(Encoder.bytesToHex("\u0037".getBytes()), "37");
        map.put(Encoder.bytesToHex("\u0038".getBytes()), "38");
        map.put(Encoder.bytesToHex("\u0039".getBytes()), "39");
        map.put(Encoder.bytesToHex("\u003A".getBytes()), "3A");
        map.put(Encoder.bytesToHex("\u003B".getBytes()), "3B");
        map.put(Encoder.bytesToHex("\u003C".getBytes()), "3C");
        map.put(Encoder.bytesToHex("\u003D".getBytes()), "3D");
        map.put(Encoder.bytesToHex("\u003E".getBytes()), "3E");
        map.put(Encoder.bytesToHex("\u003F".getBytes()), "3F");
        map.put(Encoder.bytesToHex("\u00A1".getBytes()), "40");
        map.put(Encoder.bytesToHex("\u0041".getBytes()), "41");
        map.put(Encoder.bytesToHex("\u0042".getBytes()), "42");
        map.put(Encoder.bytesToHex("\u0043".getBytes()), "43");
        map.put(Encoder.bytesToHex("\u0044".getBytes()), "44");
        map.put(Encoder.bytesToHex("\u0045".getBytes()), "45");
        map.put(Encoder.bytesToHex("\u0046".getBytes()), "46");
        map.put(Encoder.bytesToHex("\u0047".getBytes()), "47");
        map.put(Encoder.bytesToHex("\u0048".getBytes()), "48");
        map.put(Encoder.bytesToHex("\u0049".getBytes()), "49");
        map.put(Encoder.bytesToHex("\u004A".getBytes()), "4A");
        map.put(Encoder.bytesToHex("\u004B".getBytes()), "4B");
        map.put(Encoder.bytesToHex("\u004C".getBytes()), "4C");
        map.put(Encoder.bytesToHex("\u004D".getBytes()), "4D");
        map.put(Encoder.bytesToHex("\u004E".getBytes()), "4E");
        map.put(Encoder.bytesToHex("\u004F".getBytes()), "4F");
        map.put(Encoder.bytesToHex("\u0050".getBytes()), "50");
        map.put(Encoder.bytesToHex("\u0051".getBytes()), "51");
        map.put(Encoder.bytesToHex("\u0052".getBytes()), "52");
        map.put(Encoder.bytesToHex("\u0053".getBytes()), "53");
        map.put(Encoder.bytesToHex("\u0054".getBytes()), "54");
        map.put(Encoder.bytesToHex("\u0055".getBytes()), "55");
        map.put(Encoder.bytesToHex("\u0056".getBytes()), "56");
        map.put(Encoder.bytesToHex("\u0057".getBytes()), "57");
        map.put(Encoder.bytesToHex("\u0058".getBytes()), "58");
        map.put(Encoder.bytesToHex("\u0059".getBytes()), "59");
        map.put(Encoder.bytesToHex("\u005A".getBytes()), "5A");
        map.put(Encoder.bytesToHex("\u00C4".getBytes()), "5B");
        map.put(Encoder.bytesToHex("\u00D6".getBytes()), "5C");
        map.put(Encoder.bytesToHex("\u00D1".getBytes()), "5D");
        map.put(Encoder.bytesToHex("\u00DC".getBytes()), "5E");
        map.put(Encoder.bytesToHex("\u00A7".getBytes()), "5F");
        map.put(Encoder.bytesToHex("\u00BF".getBytes()), "60");
        map.put(Encoder.bytesToHex("\u0061".getBytes()), "61");
        map.put(Encoder.bytesToHex("\u0062".getBytes()), "62");
        map.put(Encoder.bytesToHex("\u0063".getBytes()), "63");
        map.put(Encoder.bytesToHex("\u0064".getBytes()), "64");
        map.put(Encoder.bytesToHex("\u0065".getBytes()), "65");
        map.put(Encoder.bytesToHex("\u0066".getBytes()), "66");
        map.put(Encoder.bytesToHex("\u0067".getBytes()), "67");
        map.put(Encoder.bytesToHex("\u0068".getBytes()), "68");
        map.put(Encoder.bytesToHex("\u0069".getBytes()), "69");
        map.put(Encoder.bytesToHex("\u006A".getBytes()), "6A");
        map.put(Encoder.bytesToHex("\u006B".getBytes()), "6B");
        map.put(Encoder.bytesToHex("\u006C".getBytes()), "6C");
        map.put(Encoder.bytesToHex("\u006D".getBytes()), "6D");
        map.put(Encoder.bytesToHex("\u006E".getBytes()), "6E");
        map.put(Encoder.bytesToHex("\u006F".getBytes()), "6F");
        map.put(Encoder.bytesToHex("\u0070".getBytes()), "70");
        map.put(Encoder.bytesToHex("\u0071".getBytes()), "71");
        map.put(Encoder.bytesToHex("\u0072".getBytes()), "72");
        map.put(Encoder.bytesToHex("\u0073".getBytes()), "73");
        map.put(Encoder.bytesToHex("\u0074".getBytes()), "74");
        map.put(Encoder.bytesToHex("\u0075".getBytes()), "75");
        map.put(Encoder.bytesToHex("\u0076".getBytes()), "76");
        map.put(Encoder.bytesToHex("\u0077".getBytes()), "77");
        map.put(Encoder.bytesToHex("\u0078".getBytes()), "78");
        map.put(Encoder.bytesToHex("\u0079".getBytes()), "79");
        map.put(Encoder.bytesToHex("\u007A".getBytes()), "7A");
        map.put(Encoder.bytesToHex("\u00E4".getBytes()), "7B");
        map.put(Encoder.bytesToHex("\u00F6".getBytes()), "7C");
        map.put(Encoder.bytesToHex("\u00F1".getBytes()), "7D");
        map.put(Encoder.bytesToHex("\u00FC".getBytes()), "7E");
        map.put(Encoder.bytesToHex("\u00E0".getBytes()), "7F");
    }
    
    public String uniToSMS(String s){
        return map.get(s);
    }
    
    public String strToSMS(String s){
        String sms = new String();
        for (int i=0;i<s.length();++i){
            String c = s.substring(i, i+1);
            sms+=uniToSMS(Encoder.bytesToHex(c.getBytes()));
        }
        return sms;
    }
    
    
    public byte[] uniToByteSMS(String s){
        byte[] t = new byte[map.get(s).length()/2];
        
        for (int i=0;i<t.length;++i)
            t[i]=Encoder.hexToByte(map.get(s).substring(i*2, i*2+2));
        return t;
    }
    
}