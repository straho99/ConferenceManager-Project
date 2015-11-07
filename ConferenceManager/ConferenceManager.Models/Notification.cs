namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class Notification
    {
        [Key]
        public int Id { get; set; }

        [Required]
        public string Content { get; set; }

        [Required]
        public bool IsRead { get; set; }

        [Required]
        public int RecipientId { get; set; }

        public virtual User Recipient { get; set; }
    }
}
