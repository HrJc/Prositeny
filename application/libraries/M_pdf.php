<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> e85f267b1bc70e8b5f740fc3646b3abfa29e11ff
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;
    public function __construct($param = "'c', 'A4'")
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}
<<<<<<< HEAD
=======
=======
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;
    public function __construct($param = "'c', 'A4'")
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}
>>>>>>> fb1421bf144160d23d3ade7b9df1ace667368553
>>>>>>> e85f267b1bc70e8b5f740fc3646b3abfa29e11ff
 