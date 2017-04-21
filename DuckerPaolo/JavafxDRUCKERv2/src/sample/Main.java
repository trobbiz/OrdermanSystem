package sample;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.util.ArrayList;

public class Main extends Application {

    @Override
    public void start(Stage primaryStage) throws Exception{
        Parent root = FXMLLoader.load(getClass().getResource("sample.fxml"));
        primaryStage.setTitle("Hello World");
        primaryStage.setScene(new Scene(root, 300, 275));
        primaryStage.show();
        DBVerbindung();
    }
    public void DBVerbindung(){
        ArrayList<Auftrag> Auftragsliste= new ArrayList<Auftrag>();
        DBSchnittstelle DB = new DBSchnittstelle();
        Auftragsliste=DB.Bestellauswahl(Auftragsliste);
        for (int i=0; i<Auftragsliste.size(); i++){
            System.out.println(i+"\n"+Auftragsliste.get(i).print());
        }
    }

    public static void main(String[] args) {

        launch(args);
    }
}
