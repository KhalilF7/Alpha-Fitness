/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Produit;
import Service.ServiceProduit;
import Utils.DataSource;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.image.WritableImage;
import javafx.stage.FileChooser;
import javafx.stage.FileChooser.ExtensionFilter;
import javax.imageio.ImageIO;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class ProduitController implements Initializable {

    @FXML
    private TextField tfNom;
    @FXML
    private TextField tfPrix;
    @FXML
    private Button btnAjouter;
    @FXML
    private Button btnImage;
    @FXML
    private ComboBox cbCategorie;
    @FXML
    private TableView<Produit> listProduit;
    @FXML
    private TableColumn<Produit, String> colnom;
    @FXML
    private TableColumn<Produit, String> colcategorie;
    @FXML
    private TableColumn<Produit, Double> colprix;
    //@FXML
    //private TableColumn<Produit, String> colimg;
    @FXML
    private Button btnModifier;
    @FXML
    private Button btnSupprimer;
    @FXML
    private Button btnHome;
    @FXML
    private ImageView imageProduit;

    ObservableList<Produit> listP;
    ServiceProduit sp = new ServiceProduit();
    private final Connection con = DataSource.getInstance().getConnection();
    int index = -1;
    ObservableList<String> options = FXCollections.observableArrayList();

    private FileChooser filechooser;
    private File file;

    @FXML
    private Button btnAnnuler;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colnom.setCellValueFactory(new PropertyValueFactory<>("nom"));
        colcategorie.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        colprix.setCellValueFactory(new PropertyValueFactory<>("prix"));
        //colimg.setCellValueFactory(new PropertyValueFactory<Produit, String>("imgproduit"));
        listP = sp.afficher();
        listProduit.setItems(listP);

        remplirListCategories();
        cbCategorie.setItems(options);
    }

    @FXML
    private void AjouterProduit(ActionEvent event) throws FileNotFoundException, MalformedURLException {

        if (verifInputs()) {
            if (!sp.produitExist(tfNom.getText())) {
                sp.ajouter(new Produit(tfNom.getText(), cbCategorie.getSelectionModel().getSelectedItem().toString(), Double.parseDouble(tfPrix.getText()), file.toURI().toURL().toString()));
            } else {
                JOptionPane.showMessageDialog(null, "Product already exists !");
            }
        } else {
            JOptionPane.showMessageDialog(null, "One or many fields are empty !");
        }
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
    }

    private void remplirListCategories() {

        try {
            String requete = "Select titre from categorie";
            ResultSet rs;
            PreparedStatement pst = con.prepareStatement(requete);
            rs = pst.executeQuery();
            while (rs.next()) {
                options.add(rs.getString("titre"));
            }
            pst.close();
            rs.close();
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @FXML
    private void SelectImage(ActionEvent event) throws IOException {
        filechooser = new FileChooser();
        filechooser.getExtensionFilters().add(new ExtensionFilter("Images", "*.jpg", "*.png", "*.jpeg", "*.gif"));
        file = filechooser.showOpenDialog(null);
        if (file != null) {
            
            BufferedImage bufferedImage = ImageIO.read(file);
            WritableImage img = SwingFXUtils.toFXImage(bufferedImage, null);
            imageProduit.setImage(img);
        }
    }

    //verifier les inputs
    private boolean verifInputs() {
        if (tfNom.getText() == null || tfPrix.getText() == null) {
            return false;
        } else {
            try {
                tfNom.getText();
                return true;
            } catch (Exception x) {
                return false;
            }
        }
    }

    @FXML
    private void ModifierProduit(ActionEvent event) throws MalformedURLException {
        String p = listProduit.getSelectionModel().getSelectedItem().getNom();
        sp.modifier1(sp.getByNom(p).getId(), tfNom.getText(), cbCategorie.getValue().toString(), Double.parseDouble(tfPrix.getText()), file.toURI().toURL().toString());
        JOptionPane.showMessageDialog(null, "Product edited successfully !");
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
    }

    @FXML
    private void SupprimerProduit(ActionEvent event) {
        //if (!tfId.getText().equals("")) {
        sp.suprimer(sp.getByNom(tfNom.getText()));
        JOptionPane.showMessageDialog(null, "Product deleted successfully ! !");
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
        //}
    }

    @FXML
    private void getSelect(javafx.scene.input.MouseEvent event) throws IOException {
        index = listProduit.getSelectionModel().getSelectedIndex();
        if (index <= -1) {
            return;
        }

        tfNom.setText(colnom.getCellData(index));
        cbCategorie.setValue(colcategorie.getCellData(index));
        tfPrix.setText(colprix.getCellData(index).toString());
        
        File f = new File(sp.getByNom(colnom.getCellData(index)).getImage().replaceAll("file:/", ""));
        //System.out.println(sp.getByNom(colnom.getCellData(index)).getImage().replaceAll("file:/", ""));
        
        BufferedImage bufferedImage = ImageIO.read(f);
        WritableImage img = SwingFXUtils.toFXImage(bufferedImage, null);
        imageProduit.setImage(img);
    }

    @FXML
    private void accueil(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnHome.getScene().setRoot(root);
    }

    @FXML
    private void annuler(ActionEvent event) {
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
    }
}
