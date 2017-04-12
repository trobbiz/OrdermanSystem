package sample;

import javafx.fxml.FXML;
import javafx.print.PrinterJob;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.shape.Circle;
import javafx.scene.text.Text;
import org.xml.sax.SAXException;


public class Controller {
    @FXML
    Button Printstart;
    @FXML
    void handleButton(){
        System.out.println("Hallo Welt");
        String Bestellung=new String("Bestellung:\n" +
                "2 Zwiebeln\t  2*15€=\t30€\n" +
                "3 Bier\t  3*3€=\t9€\n");


            Text t= new Text();
            t.setText(Bestellung);

            PrinterJob job = PrinterJob.createPrinterJob();
            if (job != null) {
                boolean success = job.printPage(t);
                if (success) {
                    job.endJob();
                }
            }


    }
}
