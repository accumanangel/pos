<?php
if ($_SESSION['role']=='admin') {
	?>
						<li class="nav-item">
                            <a href="../home/" class="nav-link">
                                <i class="nav-icon fa fa-desktop"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="../pos/" class="nav-link">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Point Of Sale
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../stock/" class="nav-link">
                                <i class="nav-icon fas fa-dolly"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="../categories/" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Categories
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="../reports/" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    Reports
                                </p>
                            </a>
                        </li>

                        
                        <li class="nav-item">
                            <a href="../customers/" class="nav-link">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>
                                    Clients
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="../expenses/" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>
                                    Expenses
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">ACCOUNT SETUP</li>

                        <li class="nav-item">
                            <a href="../employees/" class="nav-link">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../settings/" class="nav-link">
                                <i class="fa fa-cogs nav-icon"></i>
                                <p>Settings</p>
                            </a>
                        </li>
	<?php
}else{
	?>
						<li class="nav-item">
                            <a href="../home/" class="nav-link">
                                <i class="nav-icon fa fa-desktop"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="../pos/" class="nav-link">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Point Of Sale
                                </p>
                            </a>
                        </li>

                        
                        <li class="nav-item">
                            <a href="../reports/" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    Reports
                                </p>
                            </a>
                        </li>

                        

                        <li class="nav-item">
                            <a href="../customers/" class="nav-link">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>
                                    Clients
                                </p>
                            </a>
                        </li>

                        

                        
	<?php
}
?>