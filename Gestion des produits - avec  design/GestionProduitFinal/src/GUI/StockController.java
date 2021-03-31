/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Produit;
import Entite.Produit_Stock;
import Entite.Stock;
import Service.ServiceProduit;
import Service.ServiceProduit_Stock;
import Service.ServiceStock;
import Utils.DataSource;
import com.jfoenix.controls.JFXButton;
import com.jfoenix.controls.JFXComboBox;
import com.jfoenix.controls.JFXTextField;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
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
public class StockController implements Initializable {

    @FXML
    private Button btnProducts;
    @FXML
    private JFXTextField tfQuantite;
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
    private JFXComboBox<String> cbProduit;
    @FXML
    private DatePicker DpDateAjout;
    @FXML
    private TableView<Produit_Stock> listStock;
    @FXML
    private TableColumn<Produit_Stock, String> colProduit;
    @FXML
    private TableColumn<Produit_Stock, Date> colDate;
    @FXML
    private TableColumn<Produit_Stock, Integer> colQuantite;

    ObservableList<Produit_Stock> listS;
    ObservableList<Produit_Stock> list;

    ServiceStock ss = new ServiceStock();
    private final Connection con = DataSource.getInstance().getConnection();
    int index = -1;
    ObservableList<String> options = FXCollections.observableArrayList();
    ServiceProduit sp = new ServiceProduit();
    ServiceProduit_Stock sps = new ServiceProduit_Stock();
    @FXML
    private TextField searchbar;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colProduit.setCellValueFactory(new PropertyValueFactory<>("produit"));
        colDate.setCellValueFactory(new PropertyValueFactory<>("dateAjout"));
        colQuantite.setCellValueFactory(new PropertyValueFactory<>("quantite"));

        listS = sps.afficher();
        listStock.setItems(listS);

        remplirListProduits();
        cbProduit.setItems(options);

        searchStock();
    }

    private void remplirListProduits() {

        try {
            String requete = "Select nom from produit";
            ResultSet rs;
            PreparedStatement pst = con.prepareStatement(requete);
            rs = pst.executeQuery();
            while (rs.next()) {
                options.add(rs.getString("nom"));
            }
            pst.close();
            rs.close();
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @FXML
    private void productManagement(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnProducts.getScene().setRoot(root);
    }

    //verifier les inputs
    private boolean verifInputs() {
        if (cbProduit.getSelectionModel().isEmpty() || tfQuantite.getText().isEmpty() || DpDateAjout.getValue() == null) {
            return false;
        } else {
            try {
                tfQuantite.getText();
                return true;
            } catch (Exception x) {
                return false;
            }
        }
    }

    @FXML
    private void ModifierStock(ActionEvent event) {

        if (verifInputs()) {
            int s = sp.getByNom(listStock.getSelectionModel().getSelectedItem().getProduit()).getId();
            int p = sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId();
            if ((!ss.produitExist(s)) || (s == p)) {
                ss.modifier1(ss.getByProduit(s).getId(), p, Date.valueOf(DpDateAjout.getValue()), Integer.parseInt(tfQuantite.getText()));
                JOptionPane.showMessageDialog(null, "Product successfully edited in stock !");
            } else {
                JOptionPane.showMessageDialog(null, "You cannot choose this item, it is already in stock ! \n Try to choose a different one !", "Product already exists in stock !", 1);
            }
        } else {
            JOptionPane.showMessageDialog(null, "One or many fields are empty ! \n Fill in the empty fields !");
        }
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");

        searchStock();
    }

    @FXML
    private void AjouterStock(ActionEvent event) {
        if (verifInputs()) {
            if (!ss.produitExist(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId())) {
                ss.ajouter(new Stock(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId(), Date.valueOf(DpDateAjout.getValue()), Integer.parseInt(tfQuantite.getText())));
                JOptionPane.showMessageDialog(null, "Product successfully added to stock !");
            } else {
                int reponse = JOptionPane.showConfirmDialog(null, "Product already exists in stock \n Do you want to update its quantity ?", "Existing Product !", JOptionPane.YES_NO_OPTION, JOptionPane.QUESTION_MESSAGE);
                if (reponse == JOptionPane.YES_OPTION) {
                    ss.mettreAJourQte(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId(), Integer.parseInt(tfQuantite.getText()));
                }
            }
        } else {
            JOptionPane.showMessageDialog(null, "One or many fields are empty ! \n Fill in the empty fields !");
        }
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");

        searchStock();
    }

    @FXML
    private void SupprimerStock(ActionEvent event) {
        if (!cbProduit.getSelectionModel().isEmpty()) {
            ss.suprimer(ss.getByProduit(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId()));
            JOptionPane.showMessageDialog(null, "Product successfully deleted from stock !");
        } else {
            JOptionPane.showMessageDialog(null, "Choose the product to delete !");
        }
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");

        searchStock();
    }

    @FXML
    private void annuler(ActionEvent event) {
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");

        searchStock();
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
    private void Statistiques(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStatistiques.fxml"));
        Parent root = loader.load();
        btnProduits.getScene().setRoot(root);
    }

    @FXML
    private void getSelect(MouseEvent event) {
        index = listStock.getSelectionModel().getSelectedIndex();
        if (index <= -1) {
            return;
        }

        cbProduit.setValue(colProduit.getCellData(index));
        DpDateAjout.setValue(colDate.getCellData(index).toLocalDate());
        tfQuantite.setText(colQuantite.getCellData(index).toString());

    }

    @FXML
    private void searchStock() {
        list = sps.afficher();
        listStock.setItems(list);
        FilteredList<Produit_Stock> filteredData = new FilteredList<>(list, b -> true);
        searchbar.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate(stock -> {
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                String lowerCaseFilter = newValue.toLowerCase();
                if (stock.getProduit().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true;
                } else {
                    return false;
                }
            });
        });
        SortedList<Produit_Stock> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(listStock.comparatorProperty());
        listStock.setItems(sortedData);
    }

}
