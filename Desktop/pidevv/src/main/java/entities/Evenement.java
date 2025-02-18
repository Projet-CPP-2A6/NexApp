package entities;

import java.math.BigDecimal;
import java.sql.Date;

public class Evenement {
    private int id_ev; // Clé primaire avec AUTO_INCREMENT
    private String nom;
    private String type;
    private Date date_debut;
    private Date date_fin;
    private String lieu;
    private BigDecimal budget;
    private String description;
    private int id_sp; // Clé étrangère (référence un Sponsor)


    public Evenement() {
    }


    public Evenement(int id_ev, String nom, String type, Date date_debut, Date date_fin, String lieu, BigDecimal budget, String description, int id_sp) {
        this.id_ev = id_ev;
        this.nom = nom;
        this.type = type;
        this.date_debut = date_debut;
        this.date_fin = date_fin;
        this.lieu = lieu;
        this.budget = budget;
        this.description = description;
        this.id_sp = id_sp;
    }


    public Evenement(String nom, String type, Date date_debut, Date date_fin, String lieu, BigDecimal budget, String description, int id_sp) {
        this.nom = nom;
        this.type = type;
        this.date_debut = date_debut;
        this.date_fin = date_fin;
        this.lieu = lieu;
        this.budget = budget;
        this.description = description;
        this.id_sp = id_sp;
    }

    // Getters et Setters
    public int getId_ev() {
        return id_ev;
    }

    public void setId_ev(int id_ev) {
        this.id_ev = id_ev;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public Date getDate_debut() {
        return date_debut;
    }

    public void setDate_debut(Date date_debut) {
        this.date_debut = date_debut;
    }

    public Date getDate_fin() {
        return date_fin;
    }

    public void setDate_fin(Date date_fin) {
        this.date_fin = date_fin;
    }

    public String getLieu() {
        return lieu;
    }

    public void setLieu(String lieu) {
        this.lieu = lieu;
    }

    public BigDecimal getBudget() {
        return budget;
    }

    public void setBudget(BigDecimal budget) {
        this.budget = budget;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public int getId_sp() {
        return id_sp;
    }

    public void setId_sp(int id_sp) {
        this.id_sp = id_sp;
    }


    @Override
    public String toString() {
        return "Evenement{" +
                "id_ev=" + id_ev +
                ", nom='" + nom + '\'' +
                ", type='" + type + '\'' +
                ", date_debut=" + date_debut +
                ", date_fin=" + date_fin +
                ", lieu='" + lieu + '\'' +
                ", budget=" + budget +
                ", description='" + description + '\'' +
                ", id_sp=" + id_sp +
                '}';
    }
}
