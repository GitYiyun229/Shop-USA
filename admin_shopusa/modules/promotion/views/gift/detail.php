<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css"/>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>


<?php
$title = 'Mua N mặt hàng để nhận quà tặng';
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'back.png');

$arr_unitDiscount = array(
    '1' => 'VND',
    '2' => '%',
);

$this->dt_form_begin(0);

    $this->dt_form_begin(1, 2, FSText::_('Thông tin cơ bản'), '', 1, 'col-md-12 fl-left');
        TemplateHelper::dt_edit_text(FSText::_('Tên khuyến mãi'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
        TemplateHelper::datetimepicke(FSText::_('Ngày bắt đầu'), 'date_start', @$data->date_start ? @$data->date_start : '', FSText::_('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-4');
        TemplateHelper::datetimepicke(FSText::_('Ngày kết thúc'), 'date_end', @$data->date_end ? @$data->date_end : '', FSText::_('Bạn vui lòng chọn thời gian kết thúc'), 20, '', 'col-md-2', 'col-md-4');
        TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
    $this->dt_form_end_col();  

    $this->dt_form_begin(1, 2, FSText::_('Mặt hàng chính'), 'fa-bolt', 1, 'col-md-12 fl-left');
    ?>
        <div class="note">
            Thêm tối đa 100 mặt hàng chính từ cửa hàng của bạn vào chương trình khuyến mại này
        </div>
        <a href="" class="add-products">Thêm các mặt hàng chính</a>
        <div class="product-main">

        </div>
    <?php
    $this->dt_form_end_col();

    $this->dt_form_begin(1, 2, FSText::_('Cài đặt quà tặng'), 'fa-bolt', 1, 'col-md-12 fl-left');
    ?>
        <div class="note">
            Khách hàng không thể chọn hàng được tặng, khách hàng sẽ nhận được tất cả hàng được tặng nếu đặt đến ngưỡng mua của dơn hàng
        </div>
    <?php 
    $this->dt_form_end_col();

$this->dt_form_end(@$data, 0);
?>

<style>
    .note{
        color: #888;
        margin-bottom: 10px;
    }
    .add-products{
        display: inline-block;
        border-radius: 4px;
        padding: 8px 20px;
        background: #aeaeae;
        font-weight: bold;
        text-decoration: none !important;
        color: #000 !important;
    }
</style>

<script>
    $('.add-products').click(function(e) {
        e.preventDefault()
    })
</script>