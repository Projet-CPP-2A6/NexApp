#ifndef POINTAG_H
#define POINTAG_H

#include <QDialog>

namespace Ui {
class pointag;
}

class pointag : public QDialog
{
    Q_OBJECT

public:
    explicit pointag(QWidget *parent = nullptr);
    ~pointag();

private:
    Ui::pointag *ui;
};

#endif // POINTAG_H
