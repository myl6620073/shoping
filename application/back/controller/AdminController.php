<?php
/**
 * Created by PhpStorm.
 * User: Kang
 * Date: 2018/06/12
 * Time: 22:37
 */

namespace app\back\controller;

use app\back\model\Admin;
use app\back\validate\AdminValidate;
use think\Controller;
use think\Db;
use think\Session;

class AdminController extends Controller
{
    /**
     * 设置（添加和更新）动作
     */
    public function setAction($id = null)
    {

        $this->assign('id', $id);

        # 获取请求对象
        $request = request();

        $checked_roles = Db::name('role_admin')->where('admin_id',$id)->column('role_id');

        # get, 展示表单
        if ($request->isGet()) {

            ## 获取session中的消息，并分配到模板
            $message = Session::get('message') ?: [];
            $this->assign('message', $message);
            // 上次错误数据与当前正在编辑的数据进行整合
            $data = Session::get('data') ?: (!is_null($id)?Db::name('admin')->find($id) : []);
            $this->assign('data', $data);

            ## 全部角色
            $this->assign('role_list', Db::name('role')->select());
            ## 当前管理员所属的角色
            $this->assign('checked_roles', Db::name('role_admin')->where('admin_id', $id)->column('role_id'));

            ## 展示视图模板
            return $this->fetch();
        }

        # post, 处理数据
        elseif ($request->isPost()) {
            ## 验证
            $validate = new AdminValidate();
            // 验证失败
            if (! $validate->batch(true)->check($request->post())) {
                return $this->redirect('set', ['id'=>$id], 302, [
                    'message' => $validate->getError(),
                    'data' => $request->post(),
                ]);
            }

            ## 添加到数据库
            if (is_null($id)) {
                $model = new Admin();
            } else {
                $model = Admin::get($id);
            }
            $model->data($request->post());
            $result = $model->allowField(true)->save();

            if ($result) {
                # 管理员信息更新成功
                ## 更新所属的角色
                $roles = input('roles/a', []);
                ### 删除
                $deletes = array_diff($checked_roles, $roles);
                Db::name('role_admin')->where([
                    'admin_id' => $model->id,
                    'role_id' => ['in', $deletes],
                ])->delete();
                ### 插入
                $inserts = array_diff($roles, $checked_roles);
                $rows = array_map(function($role_id) use ($model) {
                    return [
                        'role_id' => $role_id,
                        'admin_id' => $model->id,
                    ];
                }, $inserts);
                Db::name('role_admin')->insertAll($rows);


//                重定向列表
                return $this->redirect('index');
            } else {
//                重定向到创建表单
                return $this->redirect('set', ['id'=>$id]);
            }
        }

    }

    /**
     * 首页
     * @return string
     */
    public function indexAction()
    {
        # 先获取空的查询构建器
        $builder = Admin::where(null);

        # 条件
        $filter = [];
        
        ## 判断是否具有username条件
        $filter_username = input('filter_username', '');
        if ('' !== $filter_username) {
            $builder->where('username', 'like', '%'. $filter_username.'%');
            $filter['filter_username'] = $filter_username;
        }

        ## 判断是否具有password条件
        $filter_password = input('filter_password', '');
        if ('' !== $filter_password) {
            $builder->where('password', 'like', '%'. $filter_password.'%');
            $filter['filter_password'] = $filter_password;
        }

        ## 搜索条件分配到模板
        $this->assign('filter', $filter);


        # 排序
        $order_field = input('order_field', '');
        $order_type = input('order_type', 'asc');
        if ('' !== $order_field) {
            $builder->order([$order_field => $order_type]);
        }
        $order = compact('order_field', 'order_type');
        $this->assign('order', $order);

        # 分页
        $limit = 10;

        # 检索数据
        $paginator = $builder->paginate($limit, false, [
            'query' => array_merge($filter, $order),
        ]);
        $this->assign('paginator', $paginator);
        // 起始记录
        $this->assign('start', $paginator->listRows()*($paginator->currentPage()-1)+1);
        // 结束记录
        $this->assign('end', min($paginator->listRows()*$paginator->currentPage(), $paginator->total()));

        # 渲染模板
        return $this->fetch();
    }

    /**
     * 批量操作
     */
    public function multiAction()
    {
        $selected = input('selected/a', []);
        if (empty($selected)) {
            return $this->redirect('index');
        }

        # 批量删除
        Admin::destroy($selected);

        return $this->redirect('index');
    }

    /**
     * 登录
     */
    public function loginAction()
    {
        $request = request();

        if($request->isGet()){
            $this->assign('message', Session::get('message') ?: '');
            $this->assign('data', Session::get('data') ?: []);

            return $this->fetch();
        }
        elseif ($request->isPost()){
            ##信息
            $username = input('username');
            $password = input('password');

            ## 校验合法性
            $condition = [
                'username' => $username,
                'password' => md5($password),
            ];
            $admin = Admin::where($condition)->find();

            if ($admin) {
                ### 校验通过，合法用户
                Session::set('admin', $admin);
                $route = Session::has('route') ? Session::pull('route') : 'site/index';
                return $this->redirect($route);
            }else{
                return $this->redirect('login', [], 302, [
                    'message' => '管理员信息错误',
                    'data' => input(),
                ]);
            }
        }




























    }
}