#ifndef CHRIF_H
#define CHRIF_H

#include <QDialog>
#include"client.h"
#include "arduino.h"
namespace Ui {
class chrif;
}

class chrif : public QDialog
{
    Q_OBJECT

public:
    explicit chrif(QWidget *parent = nullptr);
    ~chrif();

    void verifyID();
     void update_label();
signals:
    void readyRead();

private slots:
    void check_id() ;

    void on_pushButton_8_clicked();

    void on_pushButton_10_clicked();

    void on_pushButton_9_clicked();

    void on_pushButton_11_clicked();

    void on_pushButton_12_clicked();

    void on_lineEdit_textEdited(const QString &arg1);

    void on_pushButton_13_clicked();

    void on_pushButton_16_clicked();

    void on_pushButton_15_clicked();


private:
    Ui::chrif *ui;
    Client l;
    Arduino A;
};

#endif // CHRIF_H
