package sample;

import javafx.fxml.FXML;
import javafx.print.*;
import javafx.scene.control.Button;
import javafx.scene.text.Text;


public class Controller {
    @FXML
    Button Printstart;
    @FXML
    void handleButton(){

        String Bestellung=new String("\n" +
                "Bestellung:\n" +
                "2 Zwiebeln\t  2*15€=\t30€\n" +
                "3 Bier\t  3*3€=\t9€\n");
            Text t= new Text();
            t.setText(Bestellung);
        Printer printer = Printer.getDefaultPrinter();
        PageLayout pageLayout=printer.createPageLayout(Paper.A4, PageOrientation.PORTRAIT, 0,0,200,0);

            PrinterJob job = PrinterJob.createPrinterJob();
            if (job != null) {
                System.out.println(job.getJobSettings());
                boolean p=job.showPrintDialog(null);
                job.showPrintDialog(null);


                boolean success = job.printPage(pageLayout,t);
                if (success) {
                    job.endJob();
                }
            }


    }
}
