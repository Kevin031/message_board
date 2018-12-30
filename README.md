# 一个前后端分离，支持多账号登录的留言板

目前进度: 后台登录注册跑通，前端还没跑通

这是一个我在php、typescript学习阶段的项目，今后将不断完善

对你有帮助的话，欢迎来star

``后台``：基于原生``PHP7``，配合``.htaccess``实现的MVC架构

``前端``：基于``vue-cli^3.0``脚手架搭建的可视化界面，技术栈：``vue``, ``typescript``, ``JSX``, ``less``

## 使用方法

1. 后台开发环境我用的是``MAMP``, ``apache``设置``host``为``phpstudio.cc``，之后可能会改成别的，选定这个项目

2. 数据库配置写在了``/api/core/Database.php``，之后可能会抽出到``/api/config``里面

3. 了解并适配以上步骤之后，访问``phpstudio.cc/api/register``就是注册接口，这些路由在``/api/config/router``里面定义，之后考虑项目结构可能会移到别的地方

4. 前端还处于开发阶段，只需要在命令行跳到``/frontend``的路径下运行``npm run serve``，然后通过``localhost:8080``访问即可


