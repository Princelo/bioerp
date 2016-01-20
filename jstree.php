<?php
header('Content-Type: application/json');
sleep(1);
if ($_GET['id'] == '#') {
    $arr = [];
    $arr[] = ['id'=>'node1','parent'=>'#','text'=>'總經理<span class="id-remark">(id:1)</span>','icon'=>'person32px','state'=>['opened'=>true], 'type'=>'non-leaf'];
    $arr[] = ['id'=>'node2','parent'=>'node1','text'=>'總經理細佬<span class="id-remark">(id:2)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>true], 'type'=>'non-leaf'];
    $arr[] = ['id'=>'node56','parent'=>'node2','text'=>'周星馳<span class="id-remark">(id:56)</span>','icon'=>'person32px','children'=>true,'state'=>['opened'=>false], 'type'=>'non-leaf'];
    $arr[] = ['id'=>'node57','parent'=>'node2','text'=>'蔣天生<span class="id-remark">(id:57)</span>','icon'=>'person32px','children'=>true,'state'=>['opened'=>false], 'type'=>'non-leaf'];
    echo json_encode($arr);
} else if ($_GET['id'] == 'node56') {
    $arr = [];
    $arr[] = ['id'=>'node58','parent'=>'node56','text'=>'朱茵<span class="id-remark">(id:58)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    $arr[] = ['id'=>'node99','parent'=>'node56','text'=>'莫文蔚<span class="id-remark">(id:99)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    $arr[] = ['id'=>'node101','parent'=>'node56','text'=>'吳孟達<span class="id-remark">(id:101)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'non-leaf'];
    echo json_encode($arr);
} else if ($_GET['id'] == 'node57'){
    $arr = [];
    $arr[] = ['id'=>'node59','parent'=>'node57','text'=>'陳浩南<span class="id-remark">(id:59)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    $arr[] = ['id'=>'node121','parent'=>'node57','text'=>'山雞<span class="id-remark">(id:121)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    $arr[] = ['id'=>'node111','parent'=>'node57','text'=>'大天二<span class="id-remark">(id:111)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    $arr[] = ['id'=>'node178','parent'=>'node57','text'=>'包皮<span class="id-remark">(id:178)</span>','icon'=>'person32px','children'=>true,'state'=>['opened'=>false], 'type'=>'non-leaf'];
    echo json_encode($arr);
} else if ($_GET['id'] == 'node178') {
    $arr = [];
    $arr[] = ['id'=>'node279','parent'=>'node178','text'=>'蕉皮<span class="id-remark">(id:279)</span>','icon'=>'person32px','children'=>false,'state'=>['opened'=>false], 'type'=>'leaf'];
    echo json_encode($arr);
}
/*echo '[{ "id" : "node1", "parent" : "#", "text" : "總經理<span class=\"id-remark\">(id:1)</span>", "icon":"person32px",
                        state : { opened : true }
                    },
                    { "id" : "node2", "parent" : "node1", "text" : "總經理細佬<span class=\"id-remark\">(id:2)</span>", "icon":"person32px",
                        state : { opened : true }
                    }
    ';
*/
