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
        primaryStage.setScene(new Scene(root));
        primaryStage.show();

        DBVerbindung();
    }
    public void DBVerbindung(){

        DBSchnittstelle DB = new DBSchnittstelle();
        DB.Bestellauswahl();
        DB.artikelholen();
        //DB.arraydurchgehen();
        DB.bestellungensuchen();
        DB.Bestellungenausgeben();

    }

    public static void main(String[] args) {

        launch(args);
    }
}
