<?

namespace app\api\model;

use think\Model;
use think\Db;

class LoverModel extends Model
{
    protected $table = 'lovers';

    public function addLover($lover) //情侣配对接口
    {
        $lovers           = new LoverModel;
        $lovers->man = $lover['man'];
        $lovers->woman = $lover['woman'];
        $lovers->manUsername = $lover['manUsername'];
        $lovers->womanUsername = $lover['womanUsername'];
        $lovers->time = $lover['time'];
        $lovers->lid =$lover['lid'];
        $lovers->save();
        $id = $lovers->id;

        if ($id == null) {
            return ['code' => 1, 'info' => 'Ta与你擦肩而过啦~'];
        }

        return ['code' => 0, 'info' => '成功遇见，快去看看Ta吧！'];
    }
}
