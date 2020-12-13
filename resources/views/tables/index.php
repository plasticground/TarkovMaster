<body>

<header>
    <h1 class="h absolute">Tables</h1>
</header>
<div class="flex-container bg-gradient">
    <div class="box  align-items-center flex-row">
        <div class="flex-column m-1 w-25 h-50">
            <div class="shadow bg-secondary border border-m h-100">
                <div class="flex-container justify-content-center">
                    <div class="h-100">
                        <p><a href="/dashboard" class="menu">Dashboard</a></p>
                        <p><a href="/tables" class="menu">Tables</a></p>
                    </div>
                    <form class="m-x-auto h-auto m-b-1 m-t-1" action="" method="post">
                        <button name="auth" value="logout" class="btn btn-l btn-main">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex-column m-1 w-50 h-50">
            <div class="shadow bg-secondary border border-m h-100">
                <div class="h-100">
                    <div class="overflow-auto h-100">
                        <div class="flex-container">
                            @param(tableName)
                            <div class="p-1">
                                @param(currentTable)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-column m-1 w-25 h-50">
            <div class="shadow bg-secondary border border-m h-100">
                <div class="h-100">
                    <div class="overflow-auto h-75">
                        <h5 class="h m-y-auto">Tables list:</h5>
                        <div class="p-1">
                            <table class="border-m">
                                <thead>
                                <tr>
                                    <th>Schema</th>
                                    <th>Table exists</th>
                                </tr>
                                </thead>
                                <tbody>
                                @param(tableList)
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form class="d-flex justify-content-center align-items-center h-25 border-top" action="" method="post">
                        <button name="table_create" value="create_all" class="btn btn-l btn-main">Create all</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

</body>