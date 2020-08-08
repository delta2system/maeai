<?
include("connect.inc");
// $connection=mysql_connect("localhost","root","") or die("เชื่อมต่อฐานข้อมูลไม่ได้");
// mysql_select_db("thailocation") or die("ไม่สามารถเลือกฐานข้อมูลได้");
$q="SELECT * from stock_product order by barcode ASC ";
$qr=mysql_query($q);
$row_num=mysql_num_rows($qr);
$col_arr=array("รหัส","รายการ","จำนวน","หน่วยนับ","ราคา");
$col_num=count($col_arr);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=data.xls "); 
?>
<?php echo '<?xml version="1.0" encoding="windows-874"?>'; ?>
 
<?php echo'<?mso-application progid="Excel.Sheet"?>';?>
 
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Arial" x:CharSet="222"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s73">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
  </Style>
  <Style ss:ID="s78">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12"/>
  </Style>
  <Style ss:ID="s79">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12"/>
  </Style>
  <Style ss:ID="s80">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Tahoma" x:CharSet="222" x:Family="Swiss" ss:Size="12"
    ss:Bold="1"/>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
   <NumberFormat/>
  </Style>
 </Styles>
 <Worksheet ss:Name="รายงานพัสดุ">
  <Table ss:ExpandedColumnCount="<?=$col_num?>" ss:ExpandedRowCount="<?=$row_num+1?>" x:FullColumns="1"
   x:FullRows="1">
   <Column ss:Index="2" ss:AutoFitWidth="0" ss:Width="238.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="55.5"/>
   <Column ss:StyleID="s73" ss:AutoFitWidth="0" ss:Width="68.25"/>

   <Row ss:AutoFitHeight="0" ss:Height="26.25">
   <?php foreach($col_arr as $key=>$value){ ?>
    <Cell ss:StyleID="s80"><Data ss:Type="String"><?=$value?></Data></Cell>
    <?php } ?>    
   </Row>
<?php
while($rs=mysql_fetch_array($qr)){
?>   
   <Row ss:Height="15">
    <!-- <Cell><Data ss:Type="Number"><?=$rs['barcode']?></Data></Cell> -->
    <Cell ss:StyleID="s78"><Data ss:Type="String"><?=$rs['barcode']?></Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String"><?=$rs['detail']?></Data></Cell>
     <Cell ss:StyleID="s78"><Data ss:Type="Number"><?=$rs['pcs']?></Data></Cell>
      <Cell ss:StyleID="s78"><Data ss:Type="String"><?=$rs['unit']?></Data></Cell>
      <Cell ss:StyleID="s78"><Data ss:Type="Number"><?=$rs['price_in']?></Data></Cell>
   </Row>
<?php  }  ?>     
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>