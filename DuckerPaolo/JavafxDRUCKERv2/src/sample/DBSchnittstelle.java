package sample;

import javax.sound.sampled.AudioSystem;
import java.sql.*;
import java.util.ArrayList;

/**
 * Created by stortpao on 21.04.2017.
 */
public class DBSchnittstelle {

    public Connection conn;
    public DBSchnittstelle() {
        //Verbindung zur Datenbank
        try {
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            //STEP 3: Open a connection
            String DB_URL = "jdbc:mysql://linuxserver/DB4_stortpao";
            String USER = "stortpao";
            String PASS = "mypass";

            conn = DriverManager.getConnection(DB_URL, USER, PASS);
            System.out.println("Verbunden");
            
        } catch (Exception ex) {
            System.out.println("Error: unable to load driver class!");
            System.exit(1);
        }
    }



    public ArrayList<Auftrag> Bestellauswahl(ArrayList<Auftrag> Auftragsliste){
        Statement stmt;

        // es nach ungedruckte Bestellungen gesucht
        try {
            // es nach ungedruckte Bestellungen gesucht
            stmt = conn.createStatement();
            String sql = "SELECT BestellID FROM Bestellung WHERE Druckkueche=FAlSE ";
            ResultSet rs = stmt.executeQuery(sql);

        //sobald eine gefunden wird, werden die komponente dieser BEstellung gesucht
            while(rs.next()){

                int BestellID = rs.getInt("BestellID");
                Auftragsliste.add(Belegvorbereiten(BestellID));
                BestellungAktualisieren(BestellID);
            }
            stmt.close();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }


        return Auftragsliste;
    }

    private Auftrag Belegvorbereiten(int bestellID) {
        // komponente der BEstellung werden gesucht
        Statement stmt;
        Auftrag a= new Auftrag();
        try {
            stmt = conn.createStatement();
            String sql = "SELECT Gericht, Preis  FROM Bestellbewegungen  WHERE BestellID="+bestellID;
            ResultSet rs = stmt.executeQuery(sql);
            while(rs.next()){
                // und werden zu einem Auftrag zusammengefasst
                double preis= rs.getDouble("Preis");
                String gericht= rs.getString("Gericht");
                a.gesamtkosten+= preis;
                a.Beleg+="\n"+gericht+":\t\t"+preis;

            }
            stmt.close();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
            System.exit(1);
        }
        return a;
    }
    private void BestellungAktualisieren( int bestellID){
        PreparedStatement ps;
        Auftrag a= new Auftrag();
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
