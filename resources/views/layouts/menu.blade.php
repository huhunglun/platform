<ul class="nav navbar-nav">
    <li><a href="" data-toggle="modal" data-target="#createTarget">新增廣告</a></li>
    @can('isSuperAdmin',auth()->user())
        <li><a href="/socialuser">社群會員</a></li>
        <li><a href="/feedback">回饋信息</a></li>
    @endcan
</ul>
