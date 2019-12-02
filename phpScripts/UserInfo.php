<?php
if (!R::testConnection())
    exit ('Нет соединения с базой данных');

class UserInfo
{
    private $key;
    private $email;
    private $name;
    public function __construct($key, $email, $name)
    {
        $this->key = $key;
        $this->email = $email;
        $this->name = $name;
    }

    public function IsAdmin()
    {
        if(isset($this->key) && !empty($this->key))
        {
            $user = R::findOne('users', 'email = ?', array($this->email));
            if($user->root === 'admin')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    private function IsLog()
    {
        if(!empty($this->key))
            return true;
        else
            return false;
    }

    public function ModalWindowType()
    {
        if($this->IsLog() === false)
        {
            return "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Log In</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form method=\"POST\" action=\"phpScripts/LogInScript.php\">
                        <div class=\"form-group\">
                            <label for=\"email\" class=\"col-form-label\">Email:</label>
                            <input name=\"email\" type=\"email\" class=\"form-control\" id=\"email\" required>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"password\" class=\"col-form-label\">Password:</label>
                            <input name=\"password\" type=\"password\" class=\"form-control\" id=\"password\" required>
                        </div>

                    </div>
                    <div class=\"modal-footer\">
                        <a style=\"margin-right: 57%\" href=\"SignUp.php\">Register</a>
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"submit\" class=\"btn btn-primary\">Enter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
        }
        else
        {
            if($this->IsAdmin() === true)
            {
                return "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Hello $this->name</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
      
        <button class=\"btn btn-outline-danger ml-2\" onclick=\"document.location = 'CreateProductPage.php'\">Admin Panel</button>
        <a href=\"phpScripts/ExitScript.php\" class=\"float-right text-danger\">Exit</a>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>";
            }
            else
            {
                return "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Hello $this->name</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <a href=\"phpScripts/ExitScript.php\" class=\"mr-4 text-danger\">Exit</a>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>";
            }
        }
    }

    public function ModalWindowCartType()
    {
        if($this->IsLog() === false)
        {
            return "<div class=\"modal fade\" id=\"cartModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Your Cart</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        Please log in to use cart
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>";
        }
        else
        {
           /*return "<div class=\"modal fade\" id=\"cartModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLongTitle\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Your Cart</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        ...
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
        <button type=\"submit\" class=\"btn btn-primary\">Buy</button>
      </div>
    </div>
  </div>
</div>";*/
           return '';
        }
    }




    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}