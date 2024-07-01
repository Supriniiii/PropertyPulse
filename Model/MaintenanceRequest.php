<?php
class MaintenanceRequest {
    protected $db; // Assuming you have a database connection established

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function findServiceWorkersForOrder($specialization) {
        $unratedWorkers = $this->getUnratedWorkersBySpecialization($specialization);
if (!empty($unratedWorkers)) {
    // Pick a random unrated worker from the array
    $randomIndex = array_rand($unratedWorkers);
    return $unratedWorkers[$randomIndex]; 
}


        $topRatedWorkers = $this->getTopRatedWorkersBySpecialization($specialization, 0.20);
if (!empty($topRatedWorkers)) {
    // Pick a random top-rated worker from the array
    $randomIndex = array_rand($topRatedWorkers);
    $selectedWorkerId = $topRatedWorkers[$randomIndex]; 

    // Potentially replace with a middle-tier worker
    $selectedWorkerId = $this->maybeIncludeMiddleTierWorker($selectedWorkerId);

    return $selectedWorkerId; 
}

        $middleTierWorkers = $this->getMiddleTierWorkersBySpecialization($specialization);
if (!empty($middleTierWorkers)) {
    $randomIndex = array_rand($middleTierWorkers);
    $selectedWorkerId = $middleTierWorkers[$randomIndex]; 
    
    $selectedWorkerId = $this->maybeIncludeLowTierWorker($selectedWorkerId);
    
    return $selectedWorkerId; 
}

return $this->getLowTierWorkersBySpecialization($specialization)[0] ?? null; // Return a single low-tier worker if available, else null
}

        
private function getUnratedWorkersBySpecialization($specialization) {
    $sql = "SELECT WorkerID FROM serviceworker WHERE Specialization = ?";
    $unratedWorkers = [];

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $specialization);
        $stmt->execute();
        
        // Get the result set
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) { // Use $result->fetch_assoc()
            $workerId = $row['WorkerID'];

            if (!$this->workerExistsInWorkorder($workerId)) {
                $unratedWorkers[] = $workerId; 
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Log the error or display an appropriate message
        error_log("Error in getUnratedWorkersBySpecialization: " . $e->getMessage());
        return [];
    } finally {
        if ($stmt) {
            $stmt->close();
        }
    }
    
    return $unratedWorkers;
}


// Helper function to check if worker exists in workorder table
private function workerExistsInWorkorder($workerId) {
    $sql = "SELECT COUNT(*) FROM tworkorder WHERE WorkerID = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $workerId); // Assuming WorkerID is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];
    $result->close(); // Close the result set here
    $stmt->close();   // Close the statement
    return ($count > 0);
}



private function getTopRatedWorkersBySpecialization($specialization, $percentage) {
    // 1. Get the total number of workers with the given specialization
    $totalWorkerCount = $this->getTotalWorkersBySpecialization($specialization);

    // 2. Calculate the number of workers to select based on the percentage
    $numWorkersToSelect = ceil($totalWorkerCount * $percentage); // Round up

    // 3. Construct the SQL query to get top-rated workers
    $sql = "
        SELECT wo.WorkerID 
        FROM tworkorder wo
        JOIN serviceworker sw ON wo.WorkerID = sw.WorkerID
        WHERE sw.Specialization = ?
        GROUP BY wo.WorkerID
        ORDER BY AVG(wo.Rating) DESC 
        LIMIT ?
    ";

    // 4. Prepare and execute the query
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$specialization, $numWorkersToSelect]);
	$result = $stmt->get_result();
    // 5. Fetch and return the top-rated worker IDs
    $topRatedWorkers = [];
    while ($row = $result->fetch_assoc()) {
        $topRatedWorkers[] = $row['WorkerID'];
    }
    return $topRatedWorkers;
}

// Helper function to get the total number of workers with the given specialization
private function getTotalWorkersBySpecialization($specialization) {
    $sql = "SELECT COUNT(*) FROM serviceworker WHERE Specialization = ?";

    // Prepare and execute the query
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $specialization);
    $stmt->execute();
    // get the result
    $result = $stmt->get_result();
    $row = $result->fetch_row(); // fetch a row from the result set

    // Return the count
    return $row[0]; 
}



private function getMiddleTierWorkersBySpecialization($specialization) {
    $sql = "
        SELECT wo.WorkerID
        FROM tworkorder wo
        JOIN serviceworker sw ON wo.WorkerID = sw.WorkerID
        WHERE sw.Specialization = ?
        GROUP BY wo.WorkerID
        HAVING AVG(wo.Rating) BETWEEN 3.0 AND 4.0 
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$specialization]);
	$result = $stmt->get_result();
    $middleTierWorkers = [];
    while ($row = $result->fetch_assoc()) {
        $middleTierWorkers[] = $row['WorkerID'];
    }
    return $middleTierWorkers;
}


private function getLowTierWorkersBySpecialization($specialization) {
    $sql = "
        SELECT wo.WorkerID
        FROM tworkorder wo
        JOIN serviceworker sw ON wo.WorkerID = sw.WorkerID
        WHERE sw.Specialization = ?
        GROUP BY wo.WorkerID
        HAVING AVG(wo.Rating) < 3.0  -- Adjust this threshold as needed
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$specialization]);
	$result = $stmt->get_result();
    $lowTierWorkers = [];
    while ($row = $result->fetch_assoc()) {
        $lowTierWorkers[] = $row['WorkerID'];
    }
    return $lowTierWorkers;
}

private function maybeIncludeMiddleTierWorker($workerId) {
    $orderCount = $this->getOrderCount(); // Get the current order count from your tracking mechanism
    $includeMiddleTier = ($orderCount % 8 == 0); // Every 5-10 orders (average of 8)

    if ($includeMiddleTier) {
        $middleTierWorkers = $this->getMiddleTierWorkersBySpecialization($this->getSpecializationForWorker($workerId)); // Get specialization for the top-rated worker
        if (!empty($middleTierWorkers)) {
            $randomIndex = array_rand($middleTierWorkers);
            return $middleTierWorkers[$randomIndex];
        }
    }
    return $workerId; // Return original worker if no middle-tier found or not time to include
}


private function maybeIncludeLowTierWorker($workerId) {
    // Similar logic to maybeIncludeMiddleTierWorker, but adjust the interval and worker selection
    $orderCount = $this->getOrderCount();
    $includeLowTier = ($orderCount % 23 == 0); // Every 15-30 orders (average of 23)

    if ($includeLowTier) {
       $lowTierWorkers = $this->getMiddleTierWorkersBySpecialization($this->getSpecializationForWorker($workerId)); // Get specialization for the top-rated worker
        if (!empty($lowTierWorkers)) {
            $randomIndex = array_rand($lowTierWorkers);
            return $lowTierWorkers[$randomIndex];
        }
    }
    return $workerId;
}

        
private function getOrderCount() {
    // Choose one of the following storage mechanisms:

    // 1. Database Storage
    $sql = "SELECT COUNT(*) FROM tworkorder";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    return $row[0];

    // 2. File Storage
    // $orderCountFile = 'order_count.txt';
    // if (file_exists($orderCountFile)) {
    //     $orderCount = (int) file_get_contents($orderCountFile);
    // } else {
    //     $orderCount = 0;
    // }
    // return $orderCount;

    // 3. In-Memory Storage (Session or Static Variable)
    // if (!isset($_SESSION['orderCount'])) {
    //     $_SESSION['orderCount'] = 0;
    // }
    // return $_SESSION['orderCount'];
}

        private function getSpecializationForWorker($workerId) {
    $sql = "SELECT Specialization FROM serviceworker WHERE WorkerID = ?";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $workerId); // Bind as integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['Specialization'];
        } else {
            // Handle case where worker ID is not found (optional)
            throw new Exception("Worker not found with ID: $workerId"); 
        }
    } catch (mysqli_sql_exception $e) {
        // Log the error or display an appropriate message
        error_log("Error in getSpecializationForWorker: " . $e->getMessage());
        throw $e; // Re-throw the exception for higher-level handling
    } finally {
        if ($stmt) {
            $stmt->close();
        }
    }
}

}

?>