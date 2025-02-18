package services;

import entities.Evenement;
import utils.mydatabase;

import java.math.BigDecimal;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ServiceEvenement {
    private Connection connection;

    public ServiceEvenement() {
        connection = mydatabase.getInstance().getConnection();
    }


    public void ajouter(Evenement evenement) throws SQLException {
        String req = "INSERT INTO evenement (nom, type, date_debut, date_fin, lieu, budget, description, id_sp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setString(1, evenement.getNom());
        preparedStatement.setString(2, evenement.getType());
        preparedStatement.setDate(3, evenement.getDate_debut());
        preparedStatement.setDate(4, evenement.getDate_fin());
        preparedStatement.setString(5, evenement.getLieu());
        preparedStatement.setBigDecimal(6, evenement.getBudget());
        preparedStatement.setString(7, evenement.getDescription());
        preparedStatement.setInt(8, evenement.getId_sp());
        preparedStatement.executeUpdate();
        System.out.println("✅ Événement ajouté avec succès !");
    }

    public void modifier(Evenement evenement) throws SQLException {
        String req = "UPDATE evenement SET nom=?, type=?, date_debut=?, date_fin=?, lieu=?, budget=?, description=? WHERE id_ev=?";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setString(1, evenement.getNom());
        preparedStatement.setString(2, evenement.getType());
        preparedStatement.setDate(3, evenement.getDate_debut());
        preparedStatement.setDate(4, evenement.getDate_fin());
        preparedStatement.setString(5, evenement.getLieu());
        preparedStatement.setBigDecimal(6, evenement.getBudget());
        preparedStatement.setString(7, evenement.getDescription());
        preparedStatement.setInt(8, evenement.getId_ev()); // Utiliser id_ev pour identifier l'événement à mettre à jour
        preparedStatement.executeUpdate();
        System.out.println("Événement modifié avec succès !");
    }


    public void supprimer(int id) throws SQLException {
        String req = "DELETE FROM evenement WHERE id_ev=?";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setInt(1, id);
        preparedStatement.executeUpdate();
        System.out.println(" Événement supprimé avec succès !");
    }


    public List<Evenement> afficher() throws SQLException {
        List<Evenement> evenements = new ArrayList<>();
        String req = "SELECT * FROM evenement";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        ResultSet resultSet = preparedStatement.executeQuery();

        while (resultSet.next()) {
            Evenement evenement = new Evenement(
                    resultSet.getInt("id_ev"),
                    resultSet.getString("nom"),
                    resultSet.getString("type"),
                    resultSet.getDate("date_debut"),
                    resultSet.getDate("date_fin"),
                    resultSet.getString("lieu"),
                    resultSet.getBigDecimal("budget"),
                    resultSet.getString("description"),
                    resultSet.getInt("id_sp")
            );
            evenements.add(evenement);
        }
        return evenements;
    }
}
