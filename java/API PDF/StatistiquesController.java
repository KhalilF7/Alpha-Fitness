/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Service.ServiceProduit_Stock;
import Utils.DataSource;
import com.itextpdf.text.BaseColor;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.Element;
import com.itextpdf.text.Font;
import com.itextpdf.text.Image;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.Phrase;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import com.jfoenix.controls.JFXButton;
import java.awt.Desktop;
import java.awt.HeadlessException;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Arrays;
import java.util.ResourceBundle;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.CategoryAxis;
import javafx.scene.chart.NumberAxis;
import javafx.scene.chart.XYChart;
import javafx.scene.control.Button;
import javafx.scene.image.WritableImage;
import javafx.scene.layout.AnchorPane;
import javax.imageio.ImageIO;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class StatistiquesController implements Initializable {

    @FXML
    private Button btnProducts;
    @FXML
    private AnchorPane anchorPaneBar;
    @FXML
    private JFXButton btnCategories;
    @FXML
    private JFXButton btnProduits;
    @FXML
    private JFXButton btnStocks;
    @FXML
    private JFXButton btnListProduit;
    @FXML
    private JFXButton btnStatistiques;
    @FXML
    private BarChart<String, Integer> bcStock;
    @FXML
    private NumberAxis stockAxis;
    @FXML
    private CategoryAxis produitAxis;

    private final Connection cnx = DataSource.getInstance().getConnection();
    ServiceProduit_Stock sps = new ServiceProduit_Stock();
    XYChart.Series<String, Integer> series = new XYChart.Series<>();
    @FXML
    private JFXButton btnSave;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        series.setName("Stock Comparison");
        remplirListSeries();
        bcStock.getData().add(series);
    }

    private void remplirListSeries() {
        try {
            String requete = "select p.nom,s.quantite from produit p INNER JOIN stock s where p.id= s.idproduit order by p.categorie";
            ResultSet rs;
            PreparedStatement pst = cnx.prepareStatement(requete);
            rs = pst.executeQuery();
            while (rs.next()) {
                series.getData().addAll(new XYChart.Data<>(rs.getString(1), rs.getInt(2)));
            }
            pst.close();
            rs.close();
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @FXML
    private void GererCategories(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUICategorie.fxml"));
        Parent root = loader.load();
        btnCategories.getScene().setRoot(root);

    }

    @FXML
    private void GererStocks(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStock.fxml"));
        Parent root = loader.load();
        btnStocks.getScene().setRoot(root);
    }

    @FXML
    private void GererProduits(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIProduit.fxml"));
        Parent root = loader.load();
        btnProduits.getScene().setRoot(root);
    }

    @FXML
    private void Produits(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIListeProduits.fxml"));
        //FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIListeProduitsAVendre.fxml"));
        Parent root = loader.load();
        btnListProduit.getScene().setRoot(root);
    }

    @FXML
    private void productManagement(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnProducts.getScene().setRoot(root);
    }

    @FXML
    private void Statistiques(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStatistiques.fxml"));
        Parent root = loader.load();
        btnProduits.getScene().setRoot(root);
    }

    @FXML
    private void SavePDF(ActionEvent event) throws IOException, Exception {

        WritableImage image = bcStock.snapshot(null, null);
        File file = new File("C:\\Users\\user\\Desktop\\Pi\\GestionProduitFinal\\src\\IMG\\chart.png");
        ImageIO.write(SwingFXUtils.fromFXImage(image, null), "png", file);

        try {
            Document doc = new Document();
            PdfWriter.getInstance(doc, new FileOutputStream("C:\\Users\\user\\Desktop\\Pi\\GestionProduitFinal\\src\\PDF\\Stock.pdf"));
            doc.open();

            Image img = Image.getInstance("C:\\Users\\user\\Desktop\\Pi\\GestionProduitFinal\\src\\IMG\\alpha.png");
            img.scaleAbsoluteHeight(91);
            img.scaleAbsoluteWidth(120);
            img.setAlignment(Image.ALIGN_RIGHT);
            doc.open();
            doc.add(img);

            doc.add(new Paragraph(" "));
            Font font = new Font(Font.FontFamily.TIMES_ROMAN, 28, Font.UNDERLINE, BaseColor.BLACK);
            Paragraph p = new Paragraph("Stock Comparison ", font);
            p.setAlignment(Element.ALIGN_CENTER);
            doc.add(p);
            doc.add(new Paragraph(" "));
            doc.add(new Paragraph(" "));

            PdfPTable tabpdf = new PdfPTable(4);
            tabpdf.setWidthPercentage(100);

            PdfPCell cell;
            cell = new PdfPCell(new Phrase("Product"));
            cell.setHorizontalAlignment(Element.ALIGN_CENTER);
            cell.setBackgroundColor(BaseColor.WHITE);
            tabpdf.addCell(cell);

            cell = new PdfPCell(new Phrase("Collection"));
            cell.setHorizontalAlignment(Element.ALIGN_CENTER);
            cell.setBackgroundColor(BaseColor.WHITE);
            tabpdf.addCell(cell);

            cell = new PdfPCell(new Phrase("Price"));
            cell.setHorizontalAlignment(Element.ALIGN_CENTER);
            cell.setBackgroundColor(BaseColor.WHITE);
            tabpdf.addCell(cell);

            cell = new PdfPCell(new Phrase("Quantity"));
            cell.setHorizontalAlignment(Element.ALIGN_CENTER);
            cell.setBackgroundColor(BaseColor.WHITE);
            tabpdf.addCell(cell);
            String requete = "select p.nom,p.categorie,p.prix,s.quantite from produit p INNER JOIN stock s where p.id= s.idproduit order by p.categorie";
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                cell = new PdfPCell(new Phrase(rs.getString(1)));
                cell.setHorizontalAlignment(Element.ALIGN_CENTER);
                cell.setBackgroundColor(BaseColor.WHITE);
                tabpdf.addCell(cell);

                cell = new PdfPCell(new Phrase(rs.getString(2)));
                cell.setHorizontalAlignment(Element.ALIGN_CENTER);
                cell.setBackgroundColor(BaseColor.WHITE);
                tabpdf.addCell(cell);

                cell = new PdfPCell(new Phrase(String.valueOf(rs.getDouble(3))));
                cell.setHorizontalAlignment(Element.ALIGN_CENTER);
                cell.setBackgroundColor(BaseColor.WHITE);
                tabpdf.addCell(cell);

                cell = new PdfPCell(new Phrase(String.valueOf(rs.getInt(4))));
                cell.setHorizontalAlignment(Element.ALIGN_CENTER);
                cell.setBackgroundColor(BaseColor.WHITE);
                tabpdf.addCell(cell);
            }
            doc.add(tabpdf);
            Image img1 = Image.getInstance("C:\\Users\\user\\Desktop\\Pi\\GestionProduitFinal\\src\\IMG\\chart.png");
            img1.scaleAbsoluteHeight(437*3/4);
            img1.scaleAbsoluteWidth(783*3/4);
            img1.setAlignment(Image.MIDDLE);
            doc.add(img1);
            JOptionPane.showMessageDialog(null, "Success !!");
            
            /**/
            
            doc.close();
            
            Desktop.getDesktop().open(new File("C:\\Users\\user\\Desktop\\Pi\\GestionProduitFinal\\src\\PDF\\Stock.pdf"));
        } catch (DocumentException | HeadlessException | IOException e) {
            System.out.println("ERROR PDF");
            System.out.println(Arrays.toString(e.getStackTrace()));
            System.out.println(e.getMessage());
        }

    }

}
