/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Categorie;
import Service.ServiceCategorie;
import com.jfoenix.controls.JFXButton;
import com.jfoenix.controls.JFXTextField;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class CategorieController implements Initializable {

    @FXML
    private Button btnCategories;
    @FXML
    private Button btnStocks;
    @FXML
    private Button btnProduits;
    @FXML
    private Button btnListProduit;
    @FXML
    private Button btnProducts;
    @FXML
    private JFXTextField tfTitre;
    @FXML
    private TableView<Categorie> listCategories;
    @FXML
    private TableColumn<Categorie, String> colCategorie;

    ObservableList<Categorie> listC;
    ObservableList<Categorie> list;
    ServiceCategorie sc = new ServiceCategorie();
    int index = -1;
    @FXML
    private JFXButton btnStatistiques;
    @FXML
    private JFXButton btnModifier;
    @FXML
    private JFXButton btnAjouter;
    @FXML
    private JFXButton btnSupprimer;
    @FXML
    private JFXButton btnAnnuler;
    @FXML
    private AnchorPane anchorPaneBar;
    @FXML
    private TextField searchbar;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colCategorie.setCellValueFactory(new PropertyValueFactory<>("titre"));
        listC = sc.afficher();
        listCategories.setItems(listC);

        searchCategorie();
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
    private void ModifierCategorie(ActionEvent event) {
        if (!tfTitre.getText().isEmpty()) {
            String c = listCategories.getSelectionModel().getSelectedItem().getTitre();
            sc.modifier1(sc.getByTitre(c).getIdCat(), tfTitre.getText());
            JOptionPane.showMessageDialog(null, "Category successfully edited !");
        } else {
            JOptionPane.showMessageDialog(null, "The Title's field is empty ! \n Fill in the empty field !");
        }
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");

        searchCategorie();
    }

    @FXML
    private void AjouterCategorie(ActionEvent event) {
        if (!tfTitre.getText().isEmpty()) {
            sc.ajouter(new Categorie(tfTitre.getText()));
            JOptionPane.showMessageDialog(null, "Category added successfully !");
        } else {
            JOptionPane.showMessageDialog(null, "The Title's field is empty ! \n Fill in the empty field !");
        }
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");

        searchCategorie();
    }

    @FXML
    private void SupprimerCategorie(ActionEvent event) {
        if (!tfTitre.getText().isEmpty()) {
            sc.suprimer(sc.getByTitre(tfTitre.getText()));
            JOptionPane.showMessageDialog(null, "Category successfully deleted !");
        } else {
            JOptionPane.showMessageDialog(null, "Choose the collection to delete !");
        }
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");

        searchCategorie();
    }

    @FXML
    private void annuler(ActionEvent event) {
        tfTitre.setText("");

        searchCategorie();
    }

    @FXML
    private void getSelect(MouseEvent event) {
        index = listCategories.getSelectionModel().getSelectedIndex();
        if (index <= -1) {
            return;
        }

        tfTitre.setText(colCategorie.getCellData(index));

    }

    @FXML
    private void Statistiques(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStatistiques.fxml"));
        Parent root = loader.load();
        btnProduits.getScene().setRoot(root);
    }

    @FXML
    private void productManagement(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnProducts.getScene().setRoot(root);
    }

    @FXML
    private void searchCategorie() {
        list = sc.afficher();
        listCategories.setItems(list);
        FilteredList<Categorie> filteredData = new FilteredList<>(list, b -> true);
        searchbar.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate(categorie -> {
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                String lowerCaseFilter = newValue.toLowerCase();
                if (categorie.getTitre().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true;
                } else {
                    return false;
                }
            });
        });
        SortedList<Categorie> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(listCategories.comparatorProperty());
        listCategories.setItems(sortedData);
    }

}
