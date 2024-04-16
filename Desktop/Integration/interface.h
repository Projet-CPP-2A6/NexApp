#ifndef INTERFACE_H
#define INTERFACE_H
#include"partenaire.h"
#include"chat.h"
#include <QDialog>


namespace Ui {
class interface;
}

class interface : public QDialog
{
    Q_OBJECT

public:
    explicit interface(QWidget *parent = nullptr);
    ~interface();

private slots:


    void on_pushButton_8_clicked();

    void on_pushButton_9_clicked();

    void on_pushButton_10_clicked();

    void on_pushButton_11_clicked();

    void on_pushButton_12_clicked();

    void on_pushButton_13_clicked();

    void on_lineEdit_textEdited(const QString &arg1);

    void on_pushButton_16_clicked();

    void on_pushButton_15_clicked();


    void on_pushButton_clicked();
    void showNotification();

    void on_pushButton_3_clicked();

private:
    Ui::interface *ui;
     Partenaire P;
    Partenaire p;
    chat ch;
    QSqlQueryModel *model;
};

#endif // INTERFACE_H
