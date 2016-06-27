<?php
namespace Admin\Controller;

class ScheduleController extends AdminController
{
    public function index()
    {
        $this->display();
    }

    #导入
    public function import()
    {
        if (IS_POST) {
            include_once 'Application/Admin/Common/GzucmExcel.class.php';
            $excel = new GzucmExcel();
            $upload_ret = $excel->uploadExcel();
            $filename = $upload_ret['filename'];
            $excel->getSheet($filename, "教学日历模板");
            $list['name'] = $excel->getCellValue("B3");//课程名称
            $list['hours'] = $excel->getCellValue("F3");//总学时
            $list['people'] = $excel->getCellValue("H3");//人数
            $list['class'] = $excel->getCellValue("L4");//上课班级
            $list['list'] = $excel->parseExcelBySheetName(6);
            $num = $this->saveToDb($list);
            $this->success("{$num}条纪录导入成功", U('index'));
        } else {
            $this->ajaxReturn($this->fetch('import'));
        }
    }

    #导出
    public function export()
    {
        require "Addons/PHPExcel/PHPExcel.php";
        $objPHPExcel = new \PHPExcel();
        #表1,理论教学
        $this->setExcelForm($objPHPExcel,0,"理论教学");
        #表2,实验教学
        $this->setExcelForm($objPHPExcel,1,"实验教学");
        #表3,考试
        $this->setExcelForm($objPHPExcel,2,"考试");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="课表汇总.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);
        exit;
    }

    private function setExcelForm($objPHPExcel, $index, $title)
    {
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($index);
        $objPHPExcel->getActiveSheet()->setTitle($title); //设置工作表名称
        $header = array(['课程名称', '班级', '课序号', '日期', '周次', '星期', '节次', '学时', '教学环节', '教师编号', '教师', '职称', '上课地点', '分组说明', '授课内容', '备注']);
        $list = M("schedule")->where("type = '{$title}'")
            ->field("name,class,sort,date,weekly,dayOfWeek,section,hours,type,teac_num,teacher,teac_title,address,group,content,remark")
            ->order("name,class,date,weekly")->select();
        $data = array_merge($header, $list);
        $objPHPExcel->getActiveSheet()->fromArray(
            $data, // 赋值的数组
            NULL, // 忽略的值,不会在excel中显示
            'A1' // 赋值的起始位置
        );
    }

    #入库
    private function saveToDb($list)
    {
        $schedule = M("schedule");
        $i = 0;
        foreach ($list['list'] as $k => $v) {
            $data['date'] = $v['B'];
            $data['teac_num'] = $v['H'];
            $where = array("name" => $list['name'], "teac_num" => $data['teac_num'], "class" => $list['class'], "date" => $data['date']);
            if (!$this->checklist($where)) {
                $data['name'] = $list['name'];
                $data['totalhours'] = $list['hours'];
                $data['people'] = $list['people'];
                $data['class'] = $list['class'];
                $data['date'] = $v['B'];
                $data['sort'] = $v['A'];
                $data['weekly'] = $v['C'];
                $data['dayOfWeek'] = $v['D'];
                $data['section'] = $v['E'];
                $data['hours'] = $v['F'];
                $data['type'] = $v['G'];
                $data['teac_num'] = $v['H'];
                $data['teacher'] = $v['I'];
                $data['teac_title'] = $v['J'];
                $data['address'] = $v['K'];
                $data['group'] = $v['L'];
                $data['content'] = $v['M'];
                $data['remark'] = $v['N'];
                if ($schedule->add($data)) $i++;
                unset($data);
            } else {
                unset($data);
                continue;
            }
        }
        return $i;
    }

    //检测是否重复导入,课程,老师,班级,日期相同的,不录入
    private function checklist($where)
    {
        return M("schedule")->where($where)->find() ? true : false;
    }


}