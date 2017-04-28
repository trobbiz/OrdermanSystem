package sample;

import javax.sound.sampled.AudioSystem;
import java.sql.*;
import java.util.ArrayList;

/**
 * Created by stortpao on 21.04.2017.
 */
public class DBSchnittstelle {

    public Connection conn;
    ArrayList<Bestellung> Bestellarray;
    ArrayList<Artikel> Artikelarray;

    public DBSchnittstelle() {
        //Verbindung zur Datenbank
        Bestellarray= new ArrayList<Bestellung>();
        Artikelarray= new ArrayList<Artikel>();
        try {
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            //STEP 3: Open a connection
            String DB_URL = "jdbc:mysql://linuxserver/DB2_stlarleo";
            String USER = "stlarleo";
            String PASS = "mypass";

            conn = DriverManager.getConnection(DB_URL, USER, PASS);
            System.out.println("Verbunden");

        } catch (Exception ex) {
            System.out.println("Error: unable to load driver class!");
            System.exit(1);
        }
    }

    public void Bestellauswahl(){
        Statement stmt;

        // es nach ungedruckte Bestellungen gesucht
        try {
            // es nach ungedruckte Bestellungen gesucht
            stmt = conn.createStatement();
            String sql = "SELECT b.b_id, b.tisch_id, k.k_id, k.name FROM bestellung b JOIN kellner k ON b.kellner_id = k.k_id";
            ResultSet rs = stmt.executeQuery(sql);

        //sobald eine gefunden wird, werden die komponente dieser BEstellung gesucht
            while(rs.next()){
                Bestellung b= new Bestellung();
                b.BestellID= rs.getInt("b_id");
                b.TischID = rs.getInt("tisch_id");
                b.kellnerID=rs.getInt("k_id");
                b.kellnerName= rs.getString("name");
                Bestellarray.add(b);
            }
            stmt.close();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }

    }
    public void artikelholen(){
        Statement stmt;

        // es werden die artikel von der Datenbank geholt, es wird eine lokale artikel erstellt liste
        try {
            // es nach ungedruckte Bestellungen gesucht
            stmt = conn.createStatement();
            String sql = "SELECT a_id, name, preis FROM artikel";
            ResultSet rs = stmt.executeQuery(sql);

            // hier werden die variablen in die classe geschrieben
            while(rs.next()){
                Artikel a= new Artikel();
                a.artikelID= rs.getInt("a_id");
                a.name= rs.getString("name");
                a.preis = rs.getDouble("preis");

                Artikelarray.add(a);
            }
            stmt.close();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }
    }

    public void arraydurchgehen(){
        for(int i =0; i<Bestellarray.size(); i++){
           System.out.println(Bestellarray.get(i).print());
        }
        System.out.println("\n\nArtikel\n\n");
        for(int i =0; i<Artikelarray.size(); i++){
            System.out.println(Artikelarray.get(i).print());
        }
    }

    public void bestellungensuchen(){
        for(int i =0; i<Bestellarray.size(); i++){
            GerichtefuerBestellungSuchen(Bestellarray.get(i).BestellID);
        }

    }


    public void GerichteinBestellungeinfuegen(int BestellID,ArrayList<Integer>t){

        //System.out.println("BestellID: "+BestellID+"\n");
        ArrayList<Artikel>tempArtArray= new ArrayList<Artikel>();
        for(int i=0;i<t.size();i++){
            tempArtArray.add(Artikelarray.get(i));
            //System.out.println(tempArtArray.get(i).print());
        }
        for(int i=0;i<Bestellarray.size();i++) {
            if(Bestellarray.get(i).BestellID==BestellID){
                Bestellarray.get(i).Gerichte = tempArtArray;
                break;

            }

        }
    }

    private void GerichtefuerBestellungSuchen(int BestellID) {
        // komponente der Bestellung werden gesucht
        Statement stmt;
        //System.out.println("IndexBestellung:\t"+index+"\n");

        ArrayList<Integer> temp= new ArrayList<Integer>();
        try {
            stmt = conn.createStatement();
            //es wird nach der artikelID in artbes gesucht nach der bestellID
            String sql ="SELECT artbes.art_id FROM artikel_bestellung artbes WHERE bestellung_id="+BestellID;

            ResultSet rs = stmt.executeQuery(sql);
            while(rs.next()){
                int ArtikelID= rs.getInt("art_id");
                //System.out.println("ArtikelNummer:\t"+ArtikelID+"\n");
                temp.add(ArtikelID);
            }

            stmt.close();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }
        GerichteinBestellungeinfuegen(BestellID, temp);
    }

    public void Bestellungenausgeben(){
        for(int i =0; i<Bestellarray.size(); i++){
            System.out.println(Bestellarray.get(i).print());
        }

    }




    private void BestellungAktualisieren( int bestellID){
        PreparedStatement ps;

        try {
            ps = conn.prepareStatement("UPDATE Bestellung SET Druckkueche= TRUE WHERE BestellID="+bestellID);
            ps.executeUpdate();
            ps.close();

        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }
    }


}
