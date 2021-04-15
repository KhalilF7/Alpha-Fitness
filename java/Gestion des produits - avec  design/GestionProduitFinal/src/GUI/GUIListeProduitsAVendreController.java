/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Produit_Stock;
import Service.ServiceCategorie;
import Service.ServiceProduit_Stock;
import Utils.DataSource;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.HPos;
import javafx.geometry.VPos;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.ContentDisplay;
import javafx.scene.control.Label;
import javafx.scene.control.ListCell;
import javafx.scene.control.ListView;
import javafx.scene.control.TextField;
import javafx.scene.image.ImageView;
import javafx.scene.image.WritableImage;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.ColumnConstraints;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.Priority;
import javafx.scene.layout.Region;
import javafx.scene.layout.RowConstraints;
import javax.imageio.ImageIO;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class GUIListeProduitsAVendreController implements Initializable {

    @FXML
    private ListView<Produit_Stock> listViewProduits;
    @FXML
    private ListView<String> listViewCategories;
    @FXML
    private ListView<String> listViewTri;

    private final Connection cnx = DataSource.getInstance().getConnection();
    private final ObservableList<Produit_Stock> listPS = FXCollections.observableArrayList();
    ServiceProduit_Stock sps = new ServiceProduit_Stock();

    ObservableList<Produit_Stock> list = FXCollections.observableArrayList();
    ObservableList<String> listC = FXCollections.observableArrayList();
    ObservableList<String> listT = FXCollections.observableArrayList();
    ServiceCategorie sc = new ServiceCategorie();
    @FXML
    private Button btnProducts;
    @FXML
    private TextField searchbar;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        listT.addAll("Title", "Collection", "Price");
        listViewTri.setItems(listT);

        remplirListCategories();
        listViewCategories.setItems(listC);

        remplirListProduits();
        listViewProduits.setItems(listPS);

        searchProduct();
    }

    @FXML
    private void getSelect(MouseEvent event) {
        listViewProduits.setItems(null);
        if ("All".equals(listViewCategories.getSelectionModel().getSelectedItem())) {
            listViewProduits.setItems(listPS);
        } else {
            listViewProduits.setItems(sps.triCategorie(listViewCategories.getSelectionModel().getSelectedItem()));
        }

    }

    @FXML
    private void getSelected(MouseEvent event) {
        listViewProduits.setItems(null);
        if (null != listViewTri.getSelectionModel().getSelectedItem()) {
            switch (listViewTri.getSelectionModel().getSelectedItem()) {
                case "Title":
                    listViewProduits.setItems(sps.triNom());
                    break;
                case "Collection":
                    listViewProduits.setItems(sps.triCategorie());
                    break;
                case "Price":
                    listViewProduits.setItems(sps.triPrix());
                    break;
                default:
                    break;
            }
        }

    }

    private void remplirListCategories() {
        listC.add("All");
        try {
            String requete = "Select titre from categorie";
            ResultSet rs;
            PreparedStatement pst = cnx.prepareStatement(requete);
            rs = pst.executeQuery();
            while (rs.next()) {
                listC.add(rs.getString("titre"));
            }
            pst.close();
            rs.close();
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    private void remplirListProduits() {
        listPS.addAll(sps.afficherTous());
        listViewProduits.setCellFactory((ListView<Produit_Stock> lv) -> new Cell());
    }

    @FXML
    private void Produits(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIListeProduitsAVendre.fxml"));
        Parent root = loader.load();
        btnProducts.getScene().setRoot(root);
    }

    @FXML
    private void searchProduct() {
        list.addAll(sps.afficherTous());
        listViewProduits.setItems(list);
        FilteredList<Produit_Stock> filteredData = new FilteredList<>(list, b -> true);
        searchbar.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate(produit -> {
                // If filter text is empty, display all products.
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                // Compare product name of every product with filter text.
                String lowerCaseFilter = newValue.toLowerCase();

                if (produit.getProduit().toLowerCase().contains(lowerCaseFilter)) {
                    return true; //filter matches product
                } else {
                    return false;//Does not match
                }
            });
        });

        //Wrap the FilteredList in a SortedList.
        SortedList<Produit_Stock> sortedData = new SortedList<>(filteredData);

        //put the sorted list into the listview
        listViewProduits.setItems(sortedData);
    }

    static class Cell extends ListCell<Produit_Stock> {

        Button sale = new Button("Add to Cart");
        Label produit = new Label("");
        Label prix = new Label("");
        Spinner<Integer> quantite = new Spinner<Integer>();
        GridPane pane = new GridPane();
        AnchorPane aPane = new AnchorPane();
        ImageView img = new ImageView();

        public Cell() {
            img.setFitWidth(150);
            img.setFitHeight(150);
            GridPane.setConstraints(img, 0, 0, 1, 3);
            GridPane.setValignment(img, VPos.CENTER);

            produit.setStyle("-fx-font-weight: bold; -fx-font-size: 1.5em;");
            GridPane.setConstraints(produit, 1, 0);

            sale.setStyle("-fx-background-color:  #616161; -fx-background-radius:  90; -fx-text-fill: white; -fx-font-weight: bold;");
            GridPane.setConstraints(sale, 2, 0, 1, 3);
            sale.setOnAction((ActionEvent event) -> {
                JOptionPane.showMessageDialog(null, "Mabrouk ! !");
            });
            //GridPane.setValignment(sale, VPos.TOP);

            prix.setStyle("-fx-font-size: 0.9em; -fx-font-style: italic; -fx-opacity: 0.5;");
            GridPane.setConstraints(prix, 1, 1);

            GridPane.setConstraints(quantite, 1, 2);
            GridPane.setValignment(quantite, VPos.BOTTOM);

            pane.getColumnConstraints().add(new ColumnConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.NEVER, HPos.LEFT, true));
            pane.getColumnConstraints().add(new ColumnConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.NEVER, HPos.LEFT, true));
            pane.getColumnConstraints().add(new ColumnConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.ALWAYS, HPos.CENTER, true));
            pane.getRowConstraints().add(new RowConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.NEVER, VPos.CENTER, true));
            pane.getRowConstraints().add(new RowConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.NEVER, VPos.CENTER, true));
            pane.getRowConstraints().add(new RowConstraints(Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Region.USE_COMPUTED_SIZE, Priority.ALWAYS, VPos.CENTER, true));
            pane.setHgap(1);
            pane.setVgap(1);
            pane.getChildren().setAll(img, produit, prix, sale, quantite);
            AnchorPane.setTopAnchor(pane, 0d);
            AnchorPane.setLeftAnchor(pane, 0d);
            AnchorPane.setBottomAnchor(pane, 0d);
            AnchorPane.setRightAnchor(pane, 0d);
            aPane.getChildren().add(pane);
        }

        @Override
        protected void updateItem(Produit_Stock item, boolean empty) {
            super.updateItem(item, empty);
            setGraphic(null);
            setText(null);
            setContentDisplay(ContentDisplay.LEFT);
            if (!empty && item != null) {
                File f = new File(item.getImage().replaceAll("file:/", ""));
                BufferedImage bufferedImage = null;
                try {
                    bufferedImage = ImageIO.read(f);
                } catch (IOException ex) {
                    Logger.getLogger(ListeProduitsController.class.getName()).log(Level.SEVERE, null, ex);
                }
                WritableImage image = SwingFXUtils.toFXImage(bufferedImage, null);

                img.setImage(image);
                produit.setText(item.getProduit());
                prix.setText(String.valueOf(item.getPrix()) + " DT");
                SpinnerValueFactory<Integer> qteValueFactory = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, item.getQuantite(), 1);
                quantite.setValueFactory(qteValueFactory);

                setText(null);
                setGraphic(aPane);
                setContentDisplay(ContentDisplay.GRAPHIC_ONLY);
            }
        }
    }
}
