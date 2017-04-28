package sample;


import java.util.ArrayList;
import java.util.Date;

/**
 * Created by stortpao on 21.04.2017.
 */
public class Bestellung {
    String Beleg="Kassenbon";
    Date t =new Date();
    int kellnerID;
    int BestellID;
    int TischID;
    String kellnerName;
    boolean gedruckt;
    double gesamtkosten;
    //arraylist mit artikel: id name preis
    ArrayList<Artikel>Gerichte;

    public String print(){

        t.toString();
        String ges= t.toString()+" Kellner: "+kellnerName+"\tKellnerID: "+kellnerID+"\n" +
                GerichtetoString()+
                Beleg+"\nGesamtkosten:\t"+ gesamtkosten+"\n";
        return ges;

    }

    public String GerichtetoString(){
        String s="Gerichte:\n";
        for(int i=0;i<Gerichte.size();i++){
           s+=Gerichte.get(i).print();

        }
        System.out.println(s);
        return s;
    }



}
