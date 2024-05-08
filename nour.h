#ifndef NOUR_H
#define NOUR_H

#include <QDialog>
#include"arduino.h"
#include "employe.h"


namespace Ui {
class nour;
}

class nour : public QDialog
{
    Q_OBJECT

public:
    explicit nour(QWidget *parent = nullptr);
    ~nour();

private slots:


    void on_pushButton_8_clicked();



    void on_pushButton_9_clicked();

    void on_tableView_clicked(const QModelIndex &index);



    void on_tabWidget_currentChanged(int index);
     void handleItemClicked(const QModelIndex &index);


     void on_lineEdit_2_textEdited(const QString &arg1);

     void on_pushButton_23_clicked();

     void on_pushButton_21_clicked();

     void on_pushButton_22_clicked();

 private:
    int selectedCIN;

    Employe* e;
    QModelIndex selectedIndex;
    Ui::nour *ui;
    Arduino A;
    QSerialPort *serial;

};

#endif // NOUR_H
