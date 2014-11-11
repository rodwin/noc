<?php

class RbacCommand extends CConsoleCommand {

    private $_authManager;

    public function getHelp() {
        return <<<EOD
USAGE
  rbac
DESCRIPTION
  This command generates an initial RBAC authorization hierarchy.
EOD;
    }

    /**
     * Execute the action.
     * @param array command line parameters specific for this command
     */
    public function run($args) {
        //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if (($this->_authManager = Yii::app()->authManager) === null) {
            echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
            echo "If you already added 'authManager' component in application configuration,\n";
            echo "please quit and re-enter the yiic shell.\n";
            return;
        }

        //provide the oportunity for the use to abort the request        
        echo "This command will create all operations for NOC ";
        echo "and Super Administrator role. \n";

        echo "Would you like to continue? [Yes|No] ";

        //check the input from the user and continue if they indicated yes to the above question
        if (!strncasecmp(trim(fgets(STDIN)), 'y', 1)) {

            //first we need to remove all operations, roles, child relationship and assignments
            $this->_authManager->clearAll();

            $bizrule_operation = 'return true;';
            $this->_authManager->createOperation("ABI Dashboard", "Dashboard", 'return "166374e5-cffe-42c6-95b3-41590826effd" == $params["company_id"];');
            
            $this->_authManager->createOperation("Manage " . ReceivingInventory::RECEIVING_LABEL, ReceivingInventory::RECEIVING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Add " . ReceivingInventory::RECEIVING_LABEL, ReceivingInventory::RECEIVING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Edit " . ReceivingInventory::RECEIVING_LABEL, ReceivingInventory::RECEIVING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Delete " . ReceivingInventory::RECEIVING_LABEL, ReceivingInventory::RECEIVING_LABEL . " Inventory", $bizrule_operation);

            $this->_authManager->createOperation("Manage " . OutgoingInventory::OUTGOING_LABEL, OutgoingInventory::OUTGOING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Add " . OutgoingInventory::OUTGOING_LABEL, OutgoingInventory::OUTGOING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Edit " . OutgoingInventory::OUTGOING_LABEL, OutgoingInventory::OUTGOING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Delete " . OutgoingInventory::OUTGOING_LABEL, OutgoingInventory::OUTGOING_LABEL . " Inventory", $bizrule_operation);

            $this->_authManager->createOperation("Manage " . IncomingInventory::INCOMING_LABEL, IncomingInventory::INCOMING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Add " . IncomingInventory::INCOMING_LABEL, IncomingInventory::INCOMING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Edit " . IncomingInventory::INCOMING_LABEL, IncomingInventory::INCOMING_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Delete " . IncomingInventory::INCOMING_LABEL, IncomingInventory::INCOMING_LABEL . " Inventory", $bizrule_operation);

            $this->_authManager->createOperation("Manage " . CustomerItem::CUSTOMER_ITEM_LABEL, CustomerItem::CUSTOMER_ITEM_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Add " . CustomerItem::CUSTOMER_ITEM_LABEL, CustomerItem::CUSTOMER_ITEM_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Edit " . CustomerItem::CUSTOMER_ITEM_LABEL, CustomerItem::CUSTOMER_ITEM_LABEL . " Inventory", $bizrule_operation);
            $this->_authManager->createOperation("Delete " . CustomerItem::CUSTOMER_ITEM_LABEL, CustomerItem::CUSTOMER_ITEM_LABEL . " Inventory", $bizrule_operation);

            $role = $this->_authManager->createRole("Super Administrator", "", 'return "166374e5-cffe-42c6-95b3-41590826effd" == $params["company_id"];');
            
            $role->addChild("Manage " . ReceivingInventory::RECEIVING_LABEL);
            $role->addChild("Add " . ReceivingInventory::RECEIVING_LABEL);
            $role->addChild("Edit " . ReceivingInventory::RECEIVING_LABEL);
            $role->addChild("Delete " . ReceivingInventory::RECEIVING_LABEL);

            //provide a message indicating success
            echo "Authorization hierarchy successfully generated.";
        }
    }

}
