package controller;

import javafx.fxml.FXMLLoader;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;
import entities.Sponsor;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.*;
import services.ServiceSponsor;

import java.io.IOException;
import java.sql.SQLException;
import java.util.List;
import java.util.Objects;
import javafx.scene.Node;



import javafx.scene.input.MouseEvent;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

public class AfficheSponsorController {

    @FXML
    private VBox sponsorsContainer;




    @FXML
    private ServiceSponsor serviceSponsor;





    @FXML
    private AnchorPane affichersponsor;

    public AfficheSponsorController() {
        serviceSponsor = new ServiceSponsor();


    }

    @FXML
    public void initialize() {
        afficherSponsors();

        eventModule.setOnMouseClicked(event -> {
            try {
                // Charger la page d'affichage des événements
                FXMLLoader loader = new FXMLLoader(getClass().getResource("/afficherevenement.fxml")); // Remplacez par le chemin correct
                Parent root = loader.load();

                // Obtenir la scène actuelle
                Scene scene = eventModule.getScene();

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
    private HBox eventModule;

    private void afficherSponsors() {



        try {
            List<Sponsor> sponsors = serviceSponsor.afficher(); // Récupérer les sponsors
            sponsorsContainer.getChildren().clear(); // Nettoyer le container

            // Ajouter la barre de recherche
            Pane searchPane = createSearchPane(sponsors);
            sponsorsContainer.getChildren().add(searchPane);

            // Ajouter le header
            Pane headerPane = createHeaderPane();
            sponsorsContainer.getChildren().add(headerPane);

            // Ajouter les sponsors
            for (Sponsor sponsor : sponsors) {
                Pane sponsorPane = createSponsorPane(sponsor);
                sponsorsContainer.getChildren().add(sponsorPane);
            }
        } catch (SQLException e) {
            System.err.println("Erreur lors de la récupération des sponsors : " + e.getMessage());
        }


    }


    private Pane createSearchPane(List<Sponsor> sponsors) {
        Pane searchPane = new Pane();
        searchPane.setPrefSize(700, 50);
        searchPane.setStyle("-fx-padding: 10;");


        StackPane stackPane = new StackPane();
        stackPane.setLayoutX(300);
        stackPane.setLayoutY(2);
        stackPane.setPrefWidth(300);


        javafx.scene.control.TextField searchField = new javafx.scene.control.TextField();
        searchField.setPromptText("Rechercher un sponsor...");
        searchField.setStyle(
                "-fx-background-radius: 20; " +
                        "-fx-border-radius: 20; " +
                        "-fx-border-color: lightgray; " +
                        "-fx-padding: 5 5 5 30;" +
                        "-fx-border-color: #003366; -fx-border-width: 2;"
        );


        Image searchIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/rechercher (1).png")));
        ImageView searchImageView = new ImageView(searchIcon);
        searchImageView.setFitWidth(16);
        searchImageView.setFitHeight(16);


        StackPane.setAlignment(searchImageView, Pos.CENTER_LEFT);
        StackPane.setMargin(searchImageView, new Insets(0, 0, 0, 5));


        stackPane.getChildren().addAll(searchField, searchImageView);


        Image homeIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/home.png")));
        ImageView homeImageView = new ImageView(homeIcon);
        homeImageView.setFitWidth(30);
        homeImageView.setFitHeight(30);
        homeImageView.setLayoutX(650); // Déplacé plus à droite
        homeImageView.setLayoutY(0);


        Image notificationIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/active.png")));
        ImageView notificationImageView = new ImageView(notificationIcon);
        notificationImageView.setFitWidth(30);
        notificationImageView.setFitHeight(30);
        notificationImageView.setLayoutX(700); // Déplacé plus à droite
        notificationImageView.setLayoutY(0);

        Image addIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/plus.png")));
        ImageView addImageView = new ImageView(addIcon);
        addImageView.setFitWidth(25);
        addImageView.setFitHeight(25);
        addImageView.setLayoutX(600); // Déplacé plus à droite
        addImageView.setLayoutY(0);


        Button addButton = new Button();
        addButton.setGraphic(addImageView);
        addButton.setStyle("-fx-background-color: transparent;");
        addButton.setLayoutX(600); // Déplacé plus à droite
        addButton.setLayoutY(0);


        addButton.setOnAction((ActionEvent event) -> {
            try {

                FXMLLoader loader = new FXMLLoader(getClass().getResource("/ajoutersponsor.fxml"));
                Parent root = loader.load();

                AjoutSponsorController ajoutSponsorController = loader.getController();


                Scene scene = new Scene(root);


                Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
                stage.setScene(scene);
                stage.show();
            } catch (IOException e) {
                System.err.println("Erreur lors du chargement de l'interface d'ajout de sponsor : " + e.getMessage());
            }
        });


        searchPane.getChildren().addAll(stackPane, homeImageView, notificationImageView, addButton);


        searchField.textProperty().addListener((observable, oldValue, newValue) -> {
            afficherSponsorsFiltres(sponsors, newValue);
        });

        return searchPane;
    }


    private Pane createHeaderPane() {
        Pane headerPane = new Pane();
        headerPane.setPrefSize(725, 45);  // Augmenter la hauteur à 60

        headerPane.setStyle("-fx-background-color: #003366; -fx-background-radius: 15; -fx-border-radius: 15; -fx-padding: 10; -fx-border-color:#5e0214; -fx-border-width: 7;");


        Label nomLabel = new Label("Nom");
        nomLabel.setLayoutX(20);
        nomLabel.setLayoutY(10);
        nomLabel.setStyle("-fx-font-weight: bold; -fx-font-size: 14px; -fx-text-fill: white;");

        Label typeLabel = new Label("Type");
        typeLabel.setLayoutX(150);
        typeLabel.setLayoutY(10);
        typeLabel.setStyle("-fx-font-weight: bold; -fx-font-size: 14px; -fx-text-fill: white;");

        Label telephoneLabel = new Label("Téléphone");
        telephoneLabel.setLayoutX(300);
        telephoneLabel.setLayoutY(10);
        telephoneLabel.setStyle("-fx-font-weight: bold; -fx-font-size: 14px; -fx-text-fill: white;");

        Label emailLabel = new Label("Email");
        emailLabel.setLayoutX(450);
        emailLabel.setLayoutY(10);
        emailLabel.setStyle("-fx-font-weight: bold; -fx-font-size: 14px; -fx-text-fill: white;");

        Label actionLabel = new Label("Actions");
        actionLabel.setLayoutX(600);
        actionLabel.setLayoutY(10);
        actionLabel.setStyle("-fx-font-weight: bold; -fx-font-size: 14px; -fx-text-fill: white;");

        headerPane.getChildren().addAll(nomLabel, typeLabel, telephoneLabel, emailLabel, actionLabel);
        return headerPane;
    }


    private Pane createSponsorPane(Sponsor sponsor) {
        Pane pane = new Pane();
        pane.setPrefSize(725, 50);
        pane.setStyle("-fx-background-color: white; -fx-background-radius: 15; -fx-border-radius: 15; -fx-padding: 10; -fx-border-color: #5e0214; -fx-border-width: 2;");

        Label nomLabel = new Label(sponsor.getNom());
        nomLabel.setLayoutX(20);
        nomLabel.setLayoutY(15);
        nomLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label typeLabel = new Label(sponsor.getType());
        typeLabel.setLayoutX(150);
        typeLabel.setLayoutY(15);
        typeLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label telephoneLabel = new Label(sponsor.getTelephone());
        telephoneLabel.setLayoutX(300);
        telephoneLabel.setLayoutY(15);
        telephoneLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

        Label emailLabel = new Label(sponsor.getEmail());
        emailLabel.setLayoutX(450);
        emailLabel.setLayoutY(15);
        emailLabel.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");


        Image editIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/edit.png")));
        ImageView editImageView = new ImageView(editIcon);
        editImageView.setFitWidth(20);
        editImageView.setFitHeight(20);


        Button editButton = new Button();
        editButton.setGraphic(editImageView);
        editButton.setStyle("-fx-background-color: transparent;");
        editButton.setLayoutX(600); // Déplacé pour faire de la place à l'icône "Next"
        editButton.setLayoutY(10);


        Image deleteIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/delete.png")));
        ImageView deleteImageView = new ImageView(deleteIcon);
        deleteImageView.setFitWidth(20);
        deleteImageView.setFitHeight(20);


        Button deleteButton = new Button();
        deleteButton.setGraphic(deleteImageView);
        deleteButton.setStyle("-fx-background-color: transparent;");
        deleteButton.setLayoutX(650); // Déplacé pour faire de la place à l'icône "Next"
        deleteButton.setLayoutY(10);


        Image nextIcon = new Image(Objects.requireNonNull(getClass().getResourceAsStream("/images/down-arrow.png"))); // Assurez-vous d'avoir une icône "next.png"
        ImageView nextImageView = new ImageView(nextIcon);
        nextImageView.setFitWidth(20);
        nextImageView.setFitHeight(20);


        Button nextButton = new Button();
        nextButton.setGraphic(nextImageView);
        nextButton.setStyle("-fx-background-color: transparent;");
        nextButton.setLayoutX(700); // Positionné à droite de l'icône de suppression
        nextButton.setLayoutY(10);


        nextButton.setOnAction((ActionEvent event) -> {
            // Afficher les détails du sponsor
            afficherDetailsSponsor(sponsor);
        });


        deleteButton.setOnAction((ActionEvent event) -> {
            // Créer une boîte de dialogue de confirmation
            Alert confirmationAlert = new Alert(AlertType.CONFIRMATION);
            confirmationAlert.setTitle("Confirmation");
            confirmationAlert.setHeaderText("Êtes-vous sûr de vouloir supprimer ce sponsor ?");
            confirmationAlert.setContentText("Cette action est irréversible.");


            ButtonType result = confirmationAlert.showAndWait().orElse(ButtonType.CANCEL);

            if (result == ButtonType.OK) {
                try {
                    // Si l'utilisateur confirme la suppression, procéder à la suppression
                    serviceSponsor.supprimer(sponsor.getId_sp());
                    afficherSponsors();
                } catch (SQLException e) {
                    System.err.println("Erreur lors de la suppression du sponsor : " + e.getMessage());
                }
            }
        });


        editButton.setOnAction((ActionEvent event) -> {

            nomLabel.setVisible(false);
            typeLabel.setVisible(false);
            telephoneLabel.setVisible(false);
            emailLabel.setVisible(false);


            javafx.scene.control.TextField nomTextField = new javafx.scene.control.TextField(sponsor.getNom());
            nomTextField.setLayoutX(20);
            nomTextField.setLayoutY(15);
            nomTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField typeTextField = new javafx.scene.control.TextField(sponsor.getType());
            typeTextField.setLayoutX(150);
            typeTextField.setLayoutY(15);
            typeTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField telephoneTextField = new javafx.scene.control.TextField(sponsor.getTelephone());
            telephoneTextField.setLayoutX(300);
            telephoneTextField.setLayoutY(15);
            telephoneTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");

            javafx.scene.control.TextField emailTextField = new javafx.scene.control.TextField(sponsor.getEmail());
            emailTextField.setLayoutX(450);
            emailTextField.setLayoutY(15);
            emailTextField.setStyle("-fx-font-size: 14px; -fx-font-weight: bold;");


            Button saveButton = new Button("Sauvegarder");
            saveButton.setLayoutX(650);
            saveButton.setLayoutY(15);
            saveButton.setStyle("-fx-background-color: #5e0214; -fx-text-fill: white;");


            saveButton.setOnAction((ActionEvent saveEvent) -> {
                try {
                    sponsor.setNom(nomTextField.getText());
                    sponsor.setType(typeTextField.getText());
                    sponsor.setTelephone(telephoneTextField.getText());
                    sponsor.setEmail(emailTextField.getText());

                    // Mise à jour dans la base de données
                    serviceSponsor.modifier(sponsor);

                    // Réinitialiser l'interface avec les nouvelles valeurs
                    afficherSponsors();
                } catch (SQLException e) {
                    System.err.println("Erreur lors de la sauvegarde des modifications : " + e.getMessage());
                }
            });

            // Remplacer les anciens champs par les nouveaux TextField et le bouton de sauvegarde
            pane.getChildren().clear();
            pane.getChildren().addAll(nomTextField, typeTextField, telephoneTextField, emailTextField, saveButton);
        });


        pane.getChildren().addAll(nomLabel, typeLabel, telephoneLabel, emailLabel, deleteButton, editButton, nextButton);
        return pane;
    }


    private void afficherDetailsSponsor(Sponsor sponsor) {
        // Créer une boîte de dialogue pour afficher les détails
        Alert detailsAlert = new Alert(AlertType.INFORMATION);
        detailsAlert.setTitle("Détails du Sponsor");
        detailsAlert.setHeaderText("Détails de " + sponsor.getNom());


        String details = "Nom: " + sponsor.getNom() + "\n"
                + "Type: " + sponsor.getType() + "\n"
                + "Téléphone: " + sponsor.getTelephone() + "\n"
                + "Email: " + sponsor.getEmail();

        detailsAlert.setContentText(details);

        // Afficher la boîte de dialogue
        detailsAlert.showAndWait();
    }


    private void afficherSponsorsFiltres(List<Sponsor> sponsors, String recherche) {
        sponsorsContainer.getChildren().clear();
        sponsorsContainer.getChildren().add(createSearchPane(sponsors));
        sponsorsContainer.getChildren().add(createHeaderPane());

        for (Sponsor sponsor : sponsors) {
            if (sponsor.getNom().toLowerCase().contains(recherche.toLowerCase()) ||
                    sponsor.getType().toLowerCase().contains(recherche.toLowerCase()) ||
                    sponsor.getTelephone().contains(recherche) ||
                    sponsor.getEmail().toLowerCase().contains(recherche.toLowerCase())) {
                Pane sponsorPane = createSponsorPane(sponsor);
                sponsorsContainer.getChildren().add(sponsorPane);
            }
        }
    }


}
