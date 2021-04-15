/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Produit;
import Service.ServiceProduit;
import Utils.DataSource;
import com.jfoenix.controls.JFXButton;
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
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
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
import javafx.scene.layout.AnchorPane;
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
    @FXML
    private Button btnModifier;
    @FXML
    private Button btnSupprimer;
    @FXML
    private ImageView imageProduit;
    @FXML
    private Button btnAnnuler;
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
    private TextField searchbar;

    ObservableList<Produit> listP;
    ObservableList<Produit> list;
    ServiceProduit sp = new ServiceProduit();
    private final Connection con = DataSource.getInstance().getConnection();
    int index = -1;
    ObservableList<String> options = FXCollections.observableArrayList();

    private FileChooser filechooser;
    private File file;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colnom.setCellValueFactory(new PropertyValueFactory<>("nom"));
        colcategorie.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        colprix.setCellValueFactory(new PropertyValueFactory<>("prix"));
        listP = sp.afficher();
        listProduit.setItems(listP);

        remplirListCategories();
        cbCategorie.setItems(options);

        searchProduct();
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
            JOptionPane.showMessageDialog(null, "One or many fields are empty ! \n Fill in the empty fields !");
        }
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
        searchProduct();
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
        if (tfNom.getText().isEmpty() || cbCategorie.getSelectionModel().isEmpty() || tfPrix.getText().isEmpty() || file == null) {
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
        
        if (verifInputs()) {
            String p = listProduit.getSelectionModel().getSelectedItem().getNom();
            sp.modifier1(sp.getByNom(p).getId(), tfNom.getText(), cbCategorie.getValue().toString(), Double.parseDouble(tfPrix.getText()), file.toURI().toURL().toString());
            JOptionPane.showMessageDialog(null, "Product edited successfully !");
        } else {
            JOptionPane.showMessageDialog(null, "One or many fields are empty ! \n Fill in the empty fields !");
        }
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
        searchProduct();
    }

    @FXML
    private void SupprimerProduit(ActionEvent event) {
        if (!tfNom.getText().isEmpty()) {
            sp.suprimer(sp.getByNom(tfNom.getText()));
            JOptionPane.showMessageDialog(null, "Product deleted successfully ! !");
        } else {
            JOptionPane.showMessageDialog(null, "Choose the product to delete !");
        }
        listP = sp.afficher();
        listProduit.setItems(listP);
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
        searchProduct();
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

        file = new File(sp.getByNom(colnom.getCellData(index)).getImage().replaceAll("file:/", ""));
        //System.out.println(sp.getByNom(colnom.getCellData(index)).getImage().replaceAll("file:/", ""));

        BufferedImage bufferedImage = ImageIO.read(file);
        WritableImage img = SwingFXUtils.toFXImage(bufferedImage, null);
        imageProduit.setImage(img);
    }

    @FXML
    private void annuler(ActionEvent event) {
        tfNom.setText("");
        cbCategorie.setValue("");
        tfPrix.setText("");
        imageProduit.setImage(null);
        searchProduct();
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
    private void searchProduct() {
        list = sp.afficher();
        listProduit.setItems(list);
        FilteredList<Produit> filteredData = new FilteredList<>(list, b -> true);
        searchbar.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate(produit -> {
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                String lowerCaseFilter = newValue.toLowerCase();
                if (produit.getNom().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true;
                }
                if (produit.getCategorie().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true;
                } else {
                    return false;
                }
            });
        });
        SortedList<Produit> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(listProduit.comparatorProperty());
        listProduit.setItems(sortedData);
    }
}
