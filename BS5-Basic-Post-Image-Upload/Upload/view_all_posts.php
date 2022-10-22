                <?php
                // Demo Breadcrumb 

                $is_page = 'view_all_posts.php';

                $is_current_page = ucwords(str_replace("-", " ", (basename($is_page, ".php"))));

                $page = $_SERVER['PHP_SELF'];

                $is_current_dir = ucwords(basename(dirname($page)));

                $is_current_dir_icon = '<i class="fa-solid fa-image"></i> ';

                $is_current_page_icon = '<i class="fa-solid fa-file"></i> ';

                ?>

                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item"><?php echo $is_current_dir_icon; ?> <a href="../<?php echo $is_current_dir; ?>"><?php echo $is_current_dir; ?></a></li>                   
                     <li class="breadcrumb-item active"><?php echo $is_current_page_icon; ?> <?php echo $is_current_page; ?></li>
                </ol>
                
                <!-- View All Posts Table -->
                <div class="table-responsive">
                   <table class="table table-striped table-bordered">
                      <tr>
                         <thead class="thead-white">
                             <th width="5%">ID</th>
                             <th width="85%">Image</th>                            
                             <th width="10%" colspan="2">Operations</th>
                         </thead>                                                                          
                      </tr>
                      <tr>
                      <?php
                         /*
                          * Simple Post Image Upload (BS5)
                          * Author - ic-myXMB
                          */
                         
                         // Connect to database
                         // Include db connect 
                         include("db.php");

                         // Do DB function
                         doDB();

                         // File User Image Upload Directory  
                         $file_dir = "posts";                         

                         // Query Select
                         $sql = "SELECT * FROM `posts`";
                         $posts = mysqli_query($mysqli, $sql);

                         // While
                         while ($data_post = mysqli_fetch_assoc($posts)) {
                         	
                             // Old Image
                             $old = $data_post['post_image'];

                             // Post ID     
                             $post_id = $data_post['post_id'];

                             // User Image
                             $post_image = $data_post['post_image'];

                        ?>
                        
                         <td><?php echo $post_id; ?></td>
                         <td><img height="50" width="50" class="img-responsive" src="<?php echo $file_dir; ?>/<?php echo $post_image; ?>"></td>
                         <td><a href="posts.php?delete=<?php echo $post_id; ?>" class="btn btn-danger"><span class="fa-solid fa-trash"></span></a></td> 
                         <td><a href="posts.php?opt=edit_post&post_id=<?php echo $post_id; ?>" class="btn btn-success"><span class="fa-solid fa-edit"></span></a></td>   
                      </tr>  
                      <?php
                         }
				           
                            // Delete Post
                            // If Is Get Delete 
                            if (isset($_GET['delete'])) {

                             // User Id
                             $post_id = $_GET['delete'];

                             // Query Delete
                             $sql = "DELETE FROM `posts` WHERE post_id = '$post_id'";
                             $post_delete = mysqli_query($mysqli, $sql);

                                // If post delete
                                if ($post_delete) {

                                 // Unlink Old Image
                            	 unlink("$file_dir/$old");                                    	
                                    	
                                 // Redirect 
                                 header("Location: posts.php");

                                }
                            }
                        ?>                                                          
                  </table>
               </div>
            </div>
                
