package sample;

import javafx.print.*;
import javafx.scene.control.Label;

/**
 * Created by stortpao on 21.04.2017.
 */
public class Drucker {
    public void druck(){
        String Bestellung=new String("\n" +
                "Bestellung:\n" +
                "2 Zwiebeln\t  2*15€=\t30€\n" +
                "3 Bier\t  3*3€=\t9€\n");
        Label l= new Label();
        l.setText(Bestellung);
        Printer printer = Printer.getDefaultPrinter();
        PageLayout pageLayout=printer.createPageLayout(Paper.A4, PageOrientation.PORTRAIT, 0,0,0,0);

        PrinterJob job = PrinterJob.createPrinterJob();
        if (job != null) {
            System.out.println(job.getJobSettings());
            boolean p=job.showPrintDialog(null);
            job.showPrintDialog(null);


            boolean success = job.printPage(pageLayout,l);
            if (success) {
                job.endJob();
            }
        }
    }
}
