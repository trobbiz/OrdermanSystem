package sample;

import java.util.Date;

/**
 * Created by stortpao on 21.04.2017.
 */
public class Auftrag {
    String Beleg="Kassenbeleg";
    boolean gedruckt;
    double gesamtkosten;

    public String print(){
        Date t =new Date();
        t.toString();
        String ges= t.toString()+"\n" +
                Beleg+"\nGesamtkosten:\t"+ gesamtkosten;
        return ges;

    }



}
