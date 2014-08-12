/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



import java.util.BitSet;

/**
 *
 * @author severi
 */
public class TEnc {
    public static byte[] unencodedSeptetsToEncodedSeptets(byte[] septetBytes)
        {
                byte[] txtBytes;
                byte[] txtSeptets;
                int txtBytesLen;
                BitSet bits;
                int i, j;
                txtBytes = septetBytes;
                txtBytesLen = txtBytes.length;
                bits = new BitSet();
                for (i = 0; i < txtBytesLen; i++)
                        for (j = 0; j < 7; j++)
                                if ((txtBytes[i] & (1 << j)) != 0) bits.set((i * 7) + j);
                // big diff here
                int encodedSeptetByteArrayLength = txtBytesLen * 7 / 8 + ((txtBytesLen * 7 % 8 != 0) ? 1 : 0);
                txtSeptets = new byte[encodedSeptetByteArrayLength];
                for (i = 0; i < encodedSeptetByteArrayLength; i++)
                {
                        for (j = 0; j < 8; j++)
                        {
                                txtSeptets[i] |= (byte) ((bits.get((i * 8) + j) ? 1 : 0) << j);
                        }
                }
                return txtSeptets;
        }
}
