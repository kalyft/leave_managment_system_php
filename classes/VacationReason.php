<?php
// extension not used yet
enum VacationReasonCode: string {
    case HOLIDAY = 'HOL';
    case SICK = 'SICK';
    case BEREAVEMENT = 'BEREAVE';
    case MATERNITY = 'MAT';
    case PATERNITY = 'PAT';
    case PERSONAL = 'PERSONAL';

    public function getName(): string {
        return match($this) {
            self::HOLIDAY => 'Annual Leave/Holiday',
            self::SICK => 'Sick Leave',
            self::BEREAVEMENT => 'Bereavement Leave',
            self::MATERNITY => 'Maternity Leave',
            self::PATERNITY => 'Paternity Leave',
            self::PERSONAL => 'Personal Leave',
        };
    }
}




<?php
// classes/VacationReason.php
class VacationReason {
    private $id;
    private $key;
    private $label;
    private $isActive;

    public function __construct(string $key, string $label, bool $isActive = true) {
        $this->key = $key;
        $this->label = $label;
        $this->isActive = $isActive;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getKey(): string {
        return $this->key;
    }

    public function getLabel(): string {
        return $this->label;
    }

    public function isActive(): bool {
        return $this->isActive;
    }

    // Setters
    public function setKey(string $key): void {
        $this->key = $key;
    }    
    public function setLabel(string $label): void {
        $this->label = $label;
    }    
    public function setisActive(boolean $isActive): void {
        $this->isActive = $isActive;
    }
}
?>