package entities;

public class Sponsor {
    private int id_sp; // Clé primaire avec AUTO_INCREMENT
    private String nom;
    private String type;
    private String telephone;
    private String email;


    public Sponsor() {
    }


    public Sponsor(int id_sp, String nom, String type, String telephone, String email) {
        this.id_sp = id_sp;
        this.nom = nom;
        this.type = type;
        this.telephone = telephone;
        this.email = email;
    }


    public Sponsor(String nom, String type, String telephone, String email) {
        this.nom = nom;
        this.type = type;
        this.telephone = telephone;
        this.email = email;
    }


    public int getId_sp() {
        return id_sp;
    }

    public void setId_sp(int id_sp) {
        this.id_sp = id_sp;
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

    public String getTelephone() {
        return telephone;
    }

    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }


    @Override
    public String toString() {
        return "Sponsor{" +
                "id_sp=" + id_sp +
                ", nom='" + nom + '\'' +
                ", type='" + type + '\'' +
                ", telephone='" + telephone + '\'' +
                ", email='" + email + '\'' +
                '}';
    }
}
