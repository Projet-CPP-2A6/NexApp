package controller;

import entities.Evenement;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.layout.HBox;
import javafx.stage.Stage;
import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.Pane;
import javafx.scene.layout.VBox;
import services.ServiceEvenement;
import javafx.event.ActionEvent;

import java.io.IOException;
import java.sql.SQLException;
import java.util.List;
import java.util.Objects;

public class AfficheEvenementController {

    @FXML
    private VBox evenementsContainer;

    private ServiceEvenement serviceEvenement;

    public AfficheEvenementController() {
        serviceEvenement = new ServiceEvenement();
    }

    @FXML
    public void initialize() {
        afficherEvenements();

        sponsorModule.setOnMouseClicked(event -> {
            try {
                // Charger la page d'affichage des événements
                FXMLLoader loader = new FXMLLoader(getClass().getResource("/affichersponsor.fxml")); // Remplacez par le chemin correct
                Parent root = loader.load();

                // Obtenir la scène actuelle
                Scene scene = sponsorModule.getScene();

                // Changer la scène
                Stage stage = (Stage) scene.getWindow();
                stage.setScene(new Scene(root));
                stage.show();
            } catch (IOException e) {
                System.err.println("Erreur lors du chargement de la page des événements : " + e.getMessage());
            }
        });



    }

    @FXML
    private HBox sponsorModule;

    private void afficherEvenements() {
        try {
            List<Evenement> evenements = serviceEvenement.afficher(); // Récupérer les événements
            evenementsContainer.getChildren().clear(); // Nettoyer le container

            // Ajouter la barre de recherche et l'icône +
            Pane searchPane = createSearchPane();
            evenementsContainer.getChildren().add(searchPane);

            // Ajouter les événements
            for (Evenement evenement : evenements) {
                Pane evenementPane = createEvenementPane(evenement);
                evenementsContainer.getChildren().add(evenementPane);
            }
        } catch (SQLException e) {
            System.err.println("Erreur lors de la récupération des événements : " + e.getMessage());
        }
    }

    // Crée la barre de recherche et l'icône +
    private Pane createSearchPane() {
        Pane searchPane = new Pane();
        searchPane.setPrefSize(800, 50);
        searchPane.setStyle("-fx-padding: 10;");

        // Icône Ajouter
        Image addIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/plus.png")));
        ImageView addImageView = new ImageView(addIcon);
        addImageView.setFitWidth(25);
        addImageView.setFitHeight(25);
        addImageView.setLayoutX(750); // Position à droite
        addImageView.setLayoutY(10);

        // Bouton Ajouter
        Button addButton = new Button();
        addButton.setGraphic(addImageView);
        addButton.setStyle("-fx-background-color: transparent;");
        addButton.setLayoutX(650);
        addButton.setLayoutY(10);
        addButton.setOnAction((ActionEvent event) -> {
            try {

                FXMLLoader loader = new FXMLLoader(getClass().getResource("/ajouterevenement.fxml"));
                Parent root = loader.load();


                Scene scene = new Scene(root);


                Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
                stage.setScene(scene);
                stage.show();
            } catch (IOException e) {
                System.err.println("Erreur lors du chargement de l'interface d'ajout d'événement : " + e.getMessage());
            }
        });

        // Ajouter le bouton au searchPane
        searchPane.getChildren().add(addButton);

        return searchPane;
    }

    // Crée un panneau pour chaque événement
    private Pane createEvenementPane(Evenement evenement) {
        Pane pane = new Pane();
        pane.setPrefSize(1000, 100); // Ajuster la taille pour accommoder plus d'éléments
        pane.setStyle("-fx-background-color: white; -fx-background-radius: 15; -fx-border-radius: 15; -fx-padding: 10; -fx-border-color: #5e0214; -fx-border-width: 2;");

        // Créer les labels avec une taille de police plus grande et en gras
        Label nomLabel = new Label("Nom: " + evenement.getNom());
        nomLabel.setLayoutX(20);
        nomLabel.setLayoutY(10);
        nomLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label typeLabel = new Label("Type: " + evenement.getType());
        typeLabel.setLayoutX(20);
        typeLabel.setLayoutY(30);
        typeLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label dateDebutLabel = new Label("Début: " + evenement.getDate_debut().toString());
        dateDebutLabel.setLayoutX(20);
        dateDebutLabel.setLayoutY(50);
        dateDebutLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label dateFinLabel = new Label("Fin: " + evenement.getDate_fin().toString());
        dateFinLabel.setLayoutX(20);
        dateFinLabel.setLayoutY(70);
        dateFinLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label lieuLabel = new Label("Lieu: " + evenement.getLieu());
        lieuLabel.setLayoutX(200);
        lieuLabel.setLayoutY(10);
        lieuLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label budgetLabel = new Label("Budget: " + evenement.getBudget().toString());
        budgetLabel.setLayoutX(200);
        budgetLabel.setLayoutY(30);
        budgetLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label descriptionLabel = new Label("Description: " + evenement.getDescription());
        descriptionLabel.setLayoutX(200);
        descriptionLabel.setLayoutY(50);
        descriptionLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label sponsorLabel = new Label("Sponsor: " + evenement.getId_sp()); // Afficher l'ID du sponsor
        sponsorLabel.setLayoutX(200);
        sponsorLabel.setLayoutY(70);
        sponsorLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        // Icône de suppression
        Image deleteIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/delete.png")));
        ImageView deleteImageView = new ImageView(deleteIcon);
        deleteImageView.setFitWidth(20); // Ajuster la taille de l'icône
        deleteImageView.setFitHeight(20);

        // Bouton de suppression
        Button deleteButton = new Button();
        deleteButton.setGraphic(deleteImageView); // Ajouter l'icône au bouton
        deleteButton.setStyle("-fx-background-color: transparent;"); // Bouton transparent
        deleteButton.setLayoutX(500); // Position horizontale (à gauche du bouton d'édition)
        deleteButton.setLayoutY(10); // Position verticale

        // Gestionnaire d'événements pour le bouton de suppression
        deleteButton.setOnAction((ActionEvent event) -> {
            // Créer une boîte de dialogue de confirmation
            Alert confirmationAlert = new Alert(AlertType.CONFIRMATION);
            confirmationAlert.setTitle("Confirmation");
            confirmationAlert.setHeaderText("Êtes-vous sûr de vouloir supprimer cet événement ?");
            confirmationAlert.setContentText("Cette action est irréversible.");

            // Attendre la réponse de l'utilisateur
            ButtonType result = confirmationAlert.showAndWait().orElse(ButtonType.CANCEL);

            if (result == ButtonType.OK) {
                try {
                    // Si l'utilisateur confirme la suppression, procéder à la suppression
                    serviceEvenement.supprimer(evenement.getId_ev());
                    afficherEvenements(); // Rafraîchir la liste des événements
                } catch (SQLException e) {
                    System.err.println("Erreur lors de la suppression de l'événement : " + e.getMessage());
                }
            }
        });

        // Icône d'édition
        Image editIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/edit.png")));
        ImageView editImageView = new ImageView(editIcon);
        editImageView.setFitWidth(20); // Ajuster la taille de l'icône
        editImageView.setFitHeight(20);

        // Bouton d'édition
        Button editButton = new Button();
        editButton.setGraphic(editImageView); // Ajouter l'icône au bouton
        editButton.setStyle("-fx-background-color: transparent;"); // Bouton transparent
        editButton.setLayoutX(650); // Position horizontale (à droite du bouton de suppression)
        editButton.setLayoutY(10); // Position verticale

        // Gestionnaire d'événements pour le bouton d'édition
        editButton.setOnAction((ActionEvent event) -> {
            // Remplacer les labels par des TextField pour permettre la modification
            nomLabel.setVisible(false);
            typeLabel.setVisible(false);
            dateDebutLabel.setVisible(false);
            dateFinLabel.setVisible(false);
            lieuLabel.setVisible(false);
            budgetLabel.setVisible(false);
            descriptionLabel.setVisible(false);
            sponsorLabel.setVisible(false);

            // Créer des TextField pour la modification
            javafx.scene.control.TextField nomTextField = new javafx.scene.control.TextField(evenement.getNom());
            nomTextField.setLayoutX(20);
            nomTextField.setLayoutY(10);
            nomTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField typeTextField = new javafx.scene.control.TextField(evenement.getType());
            typeTextField.setLayoutX(20);
            typeTextField.setLayoutY(30);
            typeTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField dateDebutTextField = new javafx.scene.control.TextField(evenement.getDate_debut().toString());
            dateDebutTextField.setLayoutX(20);
            dateDebutTextField.setLayoutY(50);
            dateDebutTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField dateFinTextField = new javafx.scene.control.TextField(evenement.getDate_fin().toString());
            dateFinTextField.setLayoutX(20);
            dateFinTextField.setLayoutY(70);
            dateFinTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField lieuTextField = new javafx.scene.control.TextField(evenement.getLieu());
            lieuTextField.setLayoutX(200);
            lieuTextField.setLayoutY(10);
            lieuTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField budgetTextField = new javafx.scene.control.TextField(evenement.getBudget().toString());
            budgetTextField.setLayoutX(200);
            budgetTextField.setLayoutY(30);
            budgetTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField descriptionTextField = new javafx.scene.control.TextField(evenement.getDescription());
            descriptionTextField.setLayoutX(200);
            descriptionTextField.setLayoutY(50);
            descriptionTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            // Bouton pour sauvegarder les modifications
            Button saveButton = new Button("Sauvegarder");
            saveButton.setLayoutX(650);
            saveButton.setLayoutY(70);
            saveButton.setStyle("-fx-background-color: #5e0214; -fx-text-fill: white;");

            // Gestionnaire d'événements pour le bouton de sauvegarde
            saveButton.setOnAction((ActionEvent saveEvent) -> {
                try {
                    // Mettre à jour les valeurs de l'événement
                    evenement.setNom(nomTextField.getText());
                    evenement.setType(typeTextField.getText());
                    evenement.setDate_debut(java.sql.Date.valueOf(dateDebutTextField.getText())); // Convertir en Date
                    evenement.setDate_fin(java.sql.Date.valueOf(dateFinTextField.getText())); // Convertir en Date
                    evenement.setLieu(lieuTextField.getText());
                    evenement.setBudget(new java.math.BigDecimal(budgetTextField.getText()));
                    evenement.setDescription(descriptionTextField.getText());

                    // Mettre à jour l'événement dans la base de données
                    serviceEvenement.modifier(evenement);

                    // Réafficher les événements après la modification
                    afficherEvenements();
                } catch (SQLException e) {
                    System.err.println("Erreur lors de la mise à jour de l'événement : " + e.getMessage());
                } catch (IllegalArgumentException e) {
                    System.err.println("Erreur de format de date ou de budget : " + e.getMessage());
                }
            });

            // Ajouter les TextField et le bouton de sauvegarde au panneau
            pane.getChildren().clear();
            pane.getChildren().addAll(nomTextField, typeTextField, dateDebutTextField, dateFinTextField, lieuTextField, budgetTextField, descriptionTextField, saveButton);
        });

        // Ajouter les éléments au panneau
        pane.getChildren().addAll(nomLabel, typeLabel, dateDebutLabel, dateFinLabel, lieuLabel, budgetLabel, descriptionLabel, sponsorLabel, deleteButton, editButton);
        return pane;
    }
}