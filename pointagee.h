#ifndef POINTAGEE_H
#define POINTAGEE_H

#include <QDialog>

namespace Ui {
class pointagee;
}

class pointagee : public QDialog
{
    Q_OBJECT

public:
    explicit pointagee(QWidget *parent = nullptr);
    ~pointagee();

private slots:
    void on_lineEdit_textEdited(const QString &arg1);

private:
    Ui::pointagee *ui;
};

#endif // POINTAGEE_H
