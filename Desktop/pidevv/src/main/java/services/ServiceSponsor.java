package services;
import entities.Sponsor;
import utils.mydatabase;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.ArrayList;          // Utilisation des listes dynamiques
import java.util.List;

import java.sql.ResultSet;

public class ServiceSponsor {

    private Connection connection;

    public ServiceSponsor() {
        connection = mydatabase.getInstance().getConnection();
    }

    public void ajouter(Sponsor sponsor) throws SQLException {
        String req = "INSERT INTO sponsor (nom, type, telephone, email) VALUES (?, ?, ?, ?)";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setString(1, sponsor.getNom());
        preparedStatement.setString(2, sponsor.getType());
        preparedStatement.setString(3, sponsor.getTelephone());
        preparedStatement.setString(4, sponsor.getEmail());
        preparedStatement.executeUpdate();
        System.out.println("✅ Sponsor ajouté avec succès !");
    }

    public void modifier(Sponsor sponsor) throws SQLException {
        String req = "UPDATE sponsor SET nom=?, type=?, telephone=?, email=? WHERE id_sp=?";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setString(1, sponsor.getNom());
        preparedStatement.setString(2, sponsor.getType());
        preparedStatement.setString(3, sponsor.getTelephone());
        preparedStatement.setString(4, sponsor.getEmail());
        preparedStatement.setInt(5, sponsor.getId_sp());
        preparedStatement.executeUpdate();
        System.out.println(" Sponsor modifié avec succès !");
    }


    public void supprimer(int id) throws SQLException {
        String req = "DELETE FROM sponsor WHERE id_sp=?";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        preparedStatement.setInt(1, id);
        preparedStatement.executeUpdate();
        System.out.println(" Sponsor supprimé avec succès !");
    }

    public List<Sponsor> afficher() throws SQLException {
        List<Sponsor> sponsors = new ArrayList<>();
        String req = "SELECT * FROM sponsor";
        PreparedStatement preparedStatement = connection.prepareStatement(req);
        ResultSet resultSet = preparedStatement.executeQuery();

        while (resultSet.next()) {
            int id_sp = resultSet.getInt("id_sp");
            String nom = resultSet.getString("nom");
            String type = resultSet.getString("type");
            String telephone = resultSet.getString("telephone");
            String email = resultSet.getString("email");

            // Création d'un objet Sponsor et ajout à la liste
            Sponsor sponsor = new Sponsor(id_sp, nom, type, telephone, email);
            sponsors.add(sponsor);
        }

        return sponsors;
    }


}



