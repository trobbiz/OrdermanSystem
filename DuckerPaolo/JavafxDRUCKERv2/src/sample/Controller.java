package sample;

import javafx.fxml.FXML;
import javafx.print.PageLayout;
import javafx.print.PrinterJob;
import javafx.scene.control.Button;
import javafx.scene.text.Text;
import javafx.scene.transform.Scale;
import javafx.scene.web.WebView;
import javafx.stage.Window;

import static java.lang.StrictMath.min;


public class Controller {
    @FXML
    Button Printstart;
    @FXML
    void handleButton(){

        String Bestellung=new String("Bestellung:\n" +
                "2 Zwiebeln\t  2*15€=\t30€\n" +
                "3 Bier\t  3*3€=\t9€\n");


            Text t= new Text();
            t.setText(Bestellung);

            PrinterJob job = PrinterJob.createPrinterJob();
            if (job != null) {



                PageLayout pageLayout = job.getPrinter().getDefaultPageLayout();

                
                
                
                System.out.println(job.getJobSettings());
                boolean p=job.showPrintDialog(null);
                //job.showPrintDialog(null);
                job.showPageSetupDialog(null);


                /*boolean success = job.printPage(t);
                if (success) {
                    job.endJob();
                }*/
                job.endJob();
            }


    }

}
