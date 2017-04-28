package sample;

/**
 * Created by stortpao on 28.04.2017.
 */
public class Artikel {
    int artikelID;
    String name;
    double preis;


    public String print(){

        String ges= " ArtikelID: "+artikelID+"\tName: "+name+"\tPreis:\t"+ preis+"\n";
        return ges;

    }
}
