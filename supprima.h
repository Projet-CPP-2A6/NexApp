#ifndef SUPPRIMA_H
#define SUPPRIMA_H

#include <QDialog>

namespace Ui {
class supprima;
}

class supprima : public QDialog
{
    Q_OBJECT

public:
    explicit supprima(QWidget *parent = nullptr);
    ~supprima();

private slots:
    void on_pushButton_clicked();

private:
    Ui::supprima *ui;
};

#endif // SUPPRIMA_H
