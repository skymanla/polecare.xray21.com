<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
?>
<style>
.nurse_container {position:relative; width:910px; margin: 20px auto 40px}
.bgColor {background: #3A98FC}
.indentPadding {padding: 5px}
.WhiteCenter {color:white; text-align:center}
.isDataContainer { display:none; text-align:center; align-content: center; }
</style>
<div class="nurse_container">
    <div class="bgColor noDataContainer">
        <div class="indentPadding">
            <!-- <p class="WhiteCenter NoData">현재 데이터가 없습니다.</p> -->
            <p class="WhiteCenter NoData">데이터를 가져오는 중입니다...</p>
        </div>
    </div>

    <div class="table_wrap1 isDataContainer">
        <table>
            <caption>환자 데이터 조회</caption>
            <colgroup>                
                <col width="">
                <col width="">
                <col width="">
                <col width="">
                <col width="">
                <col width="">
            </colgroup>
            <thead>
                <tr>                    
                    <th>병원명</th>
                    <th>위치</th>
                    <th>환자이름</th>
                    <th>안쪽매트</th>
                    <th>바깥쪽매트</th>
                    <th>현재시간</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div style="width: 100%;text-align:center;background:#3A98FC;padding:5px;margin-top:20px;">
            <a href="./list.php" target="_blank" style="color:white;">전체목록 확인하기</a>
        </div>
    </div>
</div>

<script>

$(function(){
    // NurseData();
    setInterval(function(){
        NurseData();
    }, 10000);
})
var a = 1;
function NurseData(){
    $.ajax({
        url: "/lib/nurse/getData.php",
        type: "post",
        dataType: "json",
        beforeSend:function(){
            
        },
        complete:function(){        
            
        },
        success: function(r){
            console.log(r);
            $('.isDataContainer').hide();
            $('.noDataContainer').show();
            $('.NoData').text("데이터를 가져오는 중입니다...");
            if(r.showClass == "NoData"){
                setTimeout(function(){
                    $('.NoData').text("현재 데이터가 없습니다.");
                }, 2000);                
            }else if(r.showClass == "getData"){                
                setTimeout(function(){
                    $('.noDataContainer').hide();
                    $('.isDataContainer').show();
                    var inData = "";
                    var equiment_etc = "";
                    for(var v of r.data){
                        var outmat_status = "";
                        switch(v.outmat_status){
                            case "2":
                                outmat_status = "O";
                                break;
                            case "1":
                                outmat_status = "X";
                                break;
                            default:
                                outmat_status = "-";
                                break;    
                        }

                        var intmat_status = "";
                        switch(v.inmat_status){
                            case "2":
                                inmat_status = "O";
                                break;
                            case "1":
                                inmat_status = "X";
                                break;
                            default:
                                inmat_status = "-";
                                break;    
                        }


                        if(v.equiment_etc == "null"){
                            equiment_etc = "-";
                        }else{
                            equiment_etc = v.equiment_etc;
                        }

                        inData += "<tr>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+v.hospid+"</td>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+equiment_etc+"</td>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+v.patient_name+"</td>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+outmat_status+"</td>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+inmat_status+"</td>";
                        inData += "<td class='txt_c' style='text-align:center;'>"+v.regdate+"</td>";
                        inData += "</tr>";
                    }
                    $('.table_wrap1 > table > tbody').html(inData);
                }, 2000)                
            }
        },  error:  function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
    });
}
</script>